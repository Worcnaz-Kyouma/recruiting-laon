<?php

namespace App\Http\Controllers;

use App\Enums\MediaListingMethod;
use App\Enums\MediaType;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\ExpectedErrors\ExpectedError;
use App\Exceptions\UnexpectedErrors\AppFailedDatabaseCommunication;
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use App\Http\Requests\CreateMediaListRequest;
use App\Http\Requests\DeleteMediaListRequest;
use App\Http\Requests\GetMediaListsByUserRequest;
use App\Http\Requests\ListingMethodsRequest;
use App\Models\Media;
use App\Models\MediaList;
use App\Services\TMDBApiService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

// TODO: Custom Errors
class MediaController extends Controller {
    private TMDBApiService $tmdb;

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
        $data = $request->validated();
        $userId = $data["user_id"];
        
        try {
            $mediaLists = MediaList::where("user_id", $userId)->get();
        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        return response()->json($mediaLists);
    }
    public function createMediaList(CreateMediaListRequest $request) { 
        $data = $request->validated();
    
        $mediaList = null;
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
    // TODO: Verify
    public function addMediaIntoMediaList(Request $request) {
        $data = $request->validated();

        try {
            $mediaList = MediaList::findOrFail($data['id']);

            $mediasIdToAttach = collect($data['media'])
                ->map(fn($media) => Media::firstOrCreate([
                    'tmdb_id' => $media['tmdb_id'],
                    'media_type' => $media['media_type'],
                ]))
                ->map(fn($media) => $media->id)
                ->toArray();

            $mediaList->medias()->syncWithoutDetaching($mediasIdToAttach); // avoids duplicates
            $mediaList->load('medias');

        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        return response()->json($mediaList);
    }
    
    // Verify
    public function deleteMediaFromMediaList(Request $request) {
        $data = $request->validated();

        try {
            $mediaList = MediaList::findOrFail($data['id']);
            $detached = $mediaList->medias()->detach($data['media_id']);

        } catch (Exception $e) {
            throw new AppFailedDatabaseCommunication($e);
        }

        if ($detached === 0) {
            throw new ExpectedError("", 404, "O media informado não está vinculado a esta lista.");
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
