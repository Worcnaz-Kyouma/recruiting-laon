<?php

namespace App\Services;

use App\Entities\TMDBMedia;
use App\Entities\Movie;
use App\Entities\TMDBError;
use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\AppFailedTMDBApiRequest;
use App\Exceptions\UnexpectedErrors\TMDBInternalError;
use App\Exceptions\ExpectedErrors\TMDBDataNotFoundError;
use App\Transformers\TMDBApi\TMDBErrorTransformer;
use Illuminate\Support\Collection;
use App\Http\DTO\PaginatedResultsDTO;
use App\Http\DTO\TopPopularMediaDTO;
use App\Transformers\TMDBApi\MovieTransformer;
use App\Transformers\TMDBApi\TVSeasonTransformer;
use App\Transformers\TMDBApi\TVSerieTransformer;
use Exception;
use Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;

// TODO: Reduce this class?
/**
 * @template T of TMDBMedia
 */
class TMDBApiService {
    private string $baseUrl;
    private int $apiVersion;
    private string $apiKey;

    private static array $appEntitiesToAPIEntitiesContextMap = [
        Movie::class => [
            'apiEntity' => 'movie',
            'transformer' => [MovieTransformer::class, "tryFromExternal"],
        ],
        TVSerie::class => [
            'apiEntity' => 'tv',
            'transformer' => [TVSerieTransformer::class, "tryFromExternal"]
        ]
    ];
    
    public function __construct(
        string $baseUrl,
        int $apiVersion,
        string $apiKey
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiVersion = $apiVersion;
        $this->apiKey = $apiKey;
    }

    // TODO: IMPORTANT Wrap it on a DTO
    /**
     * @return TopPopularMediaDTO
     */
    public function getTopPopularMedia(): TopPopularMediaDTO {
        $numberOfTopMedias = 6;

        $movies = $this->getMediasByListingMethod(Movie::class, MediaListingMethod::Popular, 1);
        $topMovies = $movies->results->take($numberOfTopMedias);

        $TVSeries = $this->getMediasByListingMethod(TVSerie::class, MediaListingMethod::Popular, 1);
        $topTVSeries = $TVSeries->results->take($numberOfTopMedias);

        $medias = new TopPopularMediaDTO($topMovies, $topTVSeries);

        return $medias;
    }

    /**
     * @param class-string<T> $mediaType
     * @return PaginatedResultsDTO<TMDBMedia>
     */
    public function getMediasByListingMethod(
        string $mediaType, 
        MediaListingMethod | MovieListingMethod | TVSerieListingMethod $listingMethod,
        int $page
    ): PaginatedResultsDTO {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];
        
        // Trending consult are special, cause trending are a entity in TMDB api
        $isTrendingConsult = $listingMethod->value === MediaListingMethod::Trending->value;

        $query = [
            "page" => $page
        ];
        $data = $isTrendingConsult
            ? $this->getAPIData($listingMethod->value, "{$apiEntitiesContext['apiEntity']}/week", $query)
            : $this->getAPIData($apiEntitiesContext["apiEntity"], $listingMethod->value, $query);
        if($data === null) return PaginatedResultsDTO::getEmptyPaginatedResults();

        $medias = $this->parseAPIResultsToTMDBMedias($apiEntitiesContext, $data["results"]);

        return PaginatedResultsDTO::fromTMDBApiPaginatedResults($data, $medias);
    }

    /**
     * @param class-string<T> $mediaType
     * @return PaginatedResultsDTO<TMDBMedia>
     */
    public function getMediasByTitle(string $mediaType, string $title, int $page): PaginatedResultsDTO {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];

        $data = $this->getAPIData(
            "search", 
            $apiEntitiesContext["apiEntity"], 
            [
                "query" => $title,
                "page" => $page,
                "include_adult" => "true"
            ]
        );
        if($data === null) return PaginatedResultsDTO::getEmptyPaginatedResults();

        $medias = $this->parseAPIResultsToTMDBMedias($apiEntitiesContext, $data["results"]);

        return PaginatedResultsDTO::fromTMDBApiPaginatedResults($data, $medias);
    }

    public function getMediaDetails(int $mediaTMDBId, string $mediaType, bool $fetchExtraData = true): TMDBMedia | null {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];

        $data = $this->getAPIData(
            $apiEntitiesContext["apiEntity"], 
            $mediaTMDBId,
            $fetchExtraData 
                ? ["append_to_response" => "translations,credits"] 
                : []
        );
        if($data === null) return null;
        
        $media = $apiEntitiesContext["transformer"]($data);
        
        if($fetchExtraData && $mediaType === TVSerie::class) {
            $seasons = collect($media->getSeasons())->map(function($season) use ($mediaTMDBId) {
                $seasonNumber = $season->getSeasonNumber();
                $seasonData = $this->getAPIData(
                    "tv", 
                    "$mediaTMDBId/season/$seasonNumber"
                );
                if($seasonData === null) throw new TMDBInternalError("Failed to fetch season data from TMDB API.");
                
                return TVSeasonTransformer::tryFromExternal($seasonData);
            })->toArray();
            
            $media->setSeasons($seasons);
        }

        return $media;
    }

    /**
     * @param array{apiEntity: string, transformer: callable} $apiEntitiesContext
     * @return Collection<TMDBMedia>
     */
    private function parseAPIResultsToTMDBMedias(array $apiEntitiesContext, array $results): Collection {
        return collect($results)
            
            ->map(fn($extMedia) => 
                $apiEntitiesContext["transformer"]($extMedia)
            );
    }

    /**
     * @param array<string, string> $query
     */
    private function getAPIData(string $apiEntity, string $endPoint, array $query = []): mixed {
        $cacheKey = "TMDB_getAPIData_{$apiEntity}_{$endPoint}_" . md5(json_encode($query));
        $cacheDurationInMinutes = 60;
        return Cache::remember($cacheKey, now()->addMinutes($cacheDurationInMinutes), function() use($apiEntity, $endPoint, $query) {
            $defaultHeaders = [
                'Authorization' => "Bearer $this->apiKey",
                'Accept'        => 'application/json'
            ];
            $defaultQuery = [
                'language' => 'en-US'
            ];
    
            try {
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders($defaultHeaders)
                    ->get(
                        "$this->baseUrl/$this->apiVersion/$apiEntity/$endPoint", 
                        array_merge($defaultQuery, $query)
                    );
                if (!$response->successful()) {
                    $error = $this->buildAppErrorFromAPIFailure($response);
                    if($error instanceof TMDBDataNotFoundError) return null;
    
                    throw $error;
                }
                $body = $response->json();

                if(array_key_exists("total_pages", $body)) {
                    $body["total_pages"] = min($body["total_pages"], 500);
                }

                return $body;
            } catch(Exception $e) {
                if($e instanceof AppError) throw $e;
    
                throw new AppFailedTMDBApiRequest($e->getMessage());
            }
        });
    }

    private function buildAppErrorFromAPIFailure(Response $response): AppError {
        $statusCode = $response->status();

        $failureBody = $response->json();
        /** @var TMDBError $tmdbError */
        $tmdbError = TMDBErrorTransformer::tryFromExternal($failureBody);

        $tmdbCode = $tmdbError->getStatusCode();
        $tmdbErrorMessage = $tmdbError->getMessage();

        if($statusCode >= 500) return new TMDBInternalError($tmdbErrorMessage);

        switch($tmdbCode) {
            case TMDBError::NOT_FOUND:
                return new TMDBDataNotFoundError($tmdbErrorMessage);
            default:
                return new TMDBInternalError($tmdbErrorMessage);
        }
    }
}