<?php

namespace App\Http\Controllers;

use App\Entities\TMDBMedia;
use App\Entities\Movie;
use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\MediaType;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\ExpectedErrors\ExpectedError;
use App\Exceptions\UnexpectedErrors\AppFailedDatabaseCommunication;
use App\Http\Requests\AddMediasIntoMediaListRequest;
use App\Http\Requests\CreateMediaListRequest;
use App\Http\Requests\DeleteMediaListRequest;
use App\Http\Requests\DeleteMediasFromMediaListRequest;
use App\Http\Requests\GetMediaListDetailsRequest;
use App\Http\Requests\GetMediaListsByUserRequest;
use App\Http\Requests\ListingMethodsRequest;
use App\Models\Media;
use App\Models\MediaList;
use App\Services\TMDBApiService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;

// TODO: Custom Errors
class MediaController extends Controller {
    private TMDBApiService $tmdb;
    private static array $mediaTypeToTMDBEntitiesMap = [
        "tv-serie" => TVSerie::class,
        "movie" => Movie::class
    ];

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getTopPopularMedias() {
        $medias = $this->tmdb->getTopPopularMedia();

        return response()->json($medias);
    }

    public function getListingMethods(ListingMethodsRequest $request) {
        $data = $request->validated();
        $mediaType = $data["media_type"];

        $genericListingMethods = collect(MediaListingMethod::values());
        $extraListingMethods = collect($mediaType === MediaType::Movie->value
            ? MovieListingMethod::values()
            : TVSerieListingMethod::values()
        );
        $listingMethods = $genericListingMethods->merge($extraListingMethods);

        return response()->json($listingMethods);
    }

    public function getMediaListsByUser(GetMediaListsByUserRequest $request) {
        $mediaListsPerPage = 5;
        $mediasPerList = 6;

        $data = $request->validated();
        $userId = $data["user_id"];
        $isPaginated = $request->has('page');
        
        try {
            $mediaLists = $isPaginated
                ? MediaList::where("user_id", $userId)->paginate($mediaListsPerPage)
                : $mediaLists = MediaList::where("user_id", $userId)->get();
                
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }
        if($mediaLists->isEmpty()) return response()->json($mediaLists);

        if($isPaginated)
            $mediaLists->getCollection()->each(function($mediaList) use ($mediasPerList) { 
                $mediaList->load(['medias' => fn($query) =>
                    $query->take($mediasPerList)
                ]);
                $this->populateTMDBMediasIntoDBMedias($mediaList["medias"]);
            });

        return response()->json($mediaLists);
    }

    public function getMediaListDetails(GetMediaListDetailsRequest $request) {
        $mediasPerPage = 20;
        $data = $request->validated();
        $id = $data["id"];
        
        try {
            $mediaList = MediaList::find($id);
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }
        if(!$mediaList) return response()->json($mediaList);

        $paginatedMedias = $mediaList->medias()->paginate($mediasPerPage);

        $this->populateTMDBMediasIntoDBMedias($paginatedMedias->getCollection());

        return response()->json([
            'mediaList' => $mediaList->only(['id', 'name', 'user_id']),
            'medias' => $paginatedMedias,
        ]);
    }

    /**
     * @param Collection<Media> $medias
     */
    private function populateTMDBMediasIntoDBMedias(Collection $medias): void {
        $medias->each(function($media) {
            $tmdbId = $media["tmdb_id"];
            $mediaType = $media["media_type"];
            $tmdbEntity = self::$mediaTypeToTMDBEntitiesMap[$mediaType];
            
            $tmdbMedia = $this->tmdb->getMediaDetails($tmdbId, $tmdbEntity, false);
            $media["tmdb_media"] = $tmdbMedia;
        });
    }

    public function createMediaList(CreateMediaListRequest $request) { 
        $data = $request->validated();
    
        try {
            $mediaList = MediaList::create($data);
        } catch (QueryException $e) {
            if($e->errorInfo[1] === 1062) 
                throw new ExpectedError("", 401, "Usuario ja possui uma lista de mesmo nome");
            else throw new AppFailedDatabaseCommunication($e);
        }

        $medias = $data["medias"];
        $mediasIdToAttach = collect($medias)
            ->map(fn($media) => Media::firstOrCreate([
                'tmdb_id' => $media["tmdb_id"],
                'media_type' => $media["media_type"],
            ]))
            ->map(fn($media) => $media->id)
            ->toArray();
        
        $mediaList->medias()->attach($mediasIdToAttach);

        $mediaList->load('medias');
        return response()->json($mediaList, 201);
    }

    public function addMediasIntoMediaList(AddMediasIntoMediaListRequest $request) {
        $data = $request->validated();

        try {
            $mediaList = MediaList::findOrFail($data['id']);

            $mediasIdToAttach = collect($data['medias'])
                ->map(fn($media) => Media::firstOrCreate([
                    'tmdb_id' => $media['tmdb_id'],
                    'media_type' => $media['media_type'],
                ]))
                ->map(fn($media) => $media->id)
                ->toArray();

            $mediaList->medias()->syncWithoutDetaching($mediasIdToAttach);

            $mediaList->load('medias');
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        return response()->json($mediaList, 201);
    }
    
    public function deleteMediasFromMediaList(DeleteMediasFromMediaListRequest $request) {
        $data = $request->validated();

        try {
            $mediaList = MediaList::findOrFail($data['id']);
            $mediasId = collect($data['medias'])->pluck('id')->toArray();
            $numberOfRowsDeleted = $mediaList->medias()->detach($mediasId);
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        if ($numberOfRowsDeleted === 0) {
            throw new ExpectedError("", 404, "A midia informada não está vinculado a esta lista.");
        }

        // If list dont have any more medias, delete it.
        try {
            if ($mediaList->medias()->count() === 0) 
                $mediaList->delete();
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        return response()->noContent();
    }
    public function deleteMediaList(DeleteMediaListRequest $request) {
        $data = $request->validated();
        $mediaListId = $data['id'];
        
        $numberOfRowsDeleted = 0;
        try {
            $numberOfRowsDeleted = MediaList::where("id", $mediaListId)->delete();
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }
        if($numberOfRowsDeleted === 0) 
            throw new ExpectedError("", 404, "Não existe lista vinculada a este codigo.");

        return response()->noContent();
    }
}
