<?php

namespace App\Services;

use App\Entities\Media;
use App\Entities\Movie;
use App\Entities\TMDBError;
use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\AppFailedTMDBApiRequest;
use App\Exceptions\UnexpectedErrors\TMDBInternalError;
use App\Exceptions\ExpectedErrors\TMDBNotFoundError;
use App\Transformers\TMDBApi\TMDBErrorTransformer;
use Illuminate\Support\Collection;
use App\Http\DTO\PaginatedResultsDTO;
use App\Transformers\TMDBApi\MovieTransformer;
use App\Transformers\TMDBApi\TVSeasonTransformer;
use App\Transformers\TMDBApi\TVSerieTransformer;
use Exception;
use Http;
use Illuminate\Http\Client\Response;

// TODO: Wrap transformers and data seek inside the api, not secure do direct see it
/**
 * @template T of Media
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

    /**
     * @return array {movies: Collection<Movie>, TVSeries: Collection<TVSerie>}
     */
    public function getTopPopularMedia(): array {
        $numberOfTopMedias = 5;

        $movies = $this->getMediasByListingMethod(Movie::class, MediaListingMethod::Popular, 1);
        $topMovies = $movies->results->take($numberOfTopMedias);

        $TVSeries = $this->getMediasByListingMethod(TVSerie::class, MediaListingMethod::Popular, 1);
        $topTVSeries = $TVSeries->results->take($numberOfTopMedias);

        $medias = [
            "movies" => $topMovies,
            "TVSeries" => $topTVSeries
        ];

        return $medias;
    }

    /**
     * @param class-string<T> $mediaType
     * @return PaginatedResultsDTO<Media>
     */
    public function getMediasByListingMethod(
        string $mediaType, 
        MediaListingMethod | MovieListingMethod | TVSerieListingMethod $listingMethod,
        int $page
    ): PaginatedResultsDTO {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];
        
        // Trending consult are special, cause trending are a entity in TMDB api
        $isTrendingConsult = $listingMethod->value === MediaListingMethod::Trending;

        $query = [
            "page" => $page
        ];
        $data = $isTrendingConsult
            ? $this->getAPIData($listingMethod->value, "{$apiEntitiesContext['apiEntity']}/week", $query)
            : $this->getAPIData($apiEntitiesContext["apiEntity"], $listingMethod->value, $query);
        if($data === null) return PaginatedResultsDTO::getEmptyPaginatedResults();

        $medias = $this->parseAPIResultsInMedias($apiEntitiesContext, $data["results"]);

        return PaginatedResultsDTO::fromTMDBApiPaginatedResults($data, $medias);
    }

    /**
     * @param class-string<T> $mediaType
     * @return PaginatedResultsDTO<Media>
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

        $medias = $this->parseAPIResultsInMedias($apiEntitiesContext, $data["results"]);

        return PaginatedResultsDTO::fromTMDBApiPaginatedResults($data, $medias);
    }

    public function getMediaDetails(int $tmdbId, string $mediaType): Media | null {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];

        $data = $this->getAPIData(
            $apiEntitiesContext["apiEntity"], 
            $tmdbId,
            ["append_to_response" => "translations,credits"]
        );
        if($data === null) return null;

        $media = $apiEntitiesContext["transformer"]((object) $data);

        // Maybe better put it in a transformer or something like this?
        if($mediaType === TVSerie::class && isset($data["seasons"])) {
            $seasons = collect($data["seasons"])->map(function($extSeason) use ($tmdbId) {
                $seasonNumber = $extSeason["season_number"];
                $seasonData = $this->getAPIData(
                    "tv", 
                    "$tmdbId/season/$seasonNumber"
                );
                if($seasonData === null) throw new TMDBInternalError("Failed to fetch season data from TMDB API.");

                return TVSeasonTransformer::tryFromExternal((object) $seasonData);
            })->toArray();

            $media->setSeasons($seasons);
        }

        return $media;
    }

    /**
     * @param array{apiEntity: string, transformer: callable} $apiEntitiesContext
     * @return Collection<Media>
     */
    private function parseAPIResultsInMedias(array $apiEntitiesContext, array $results): Collection {
        return collect($results)->map(fn($extMedia) => 
            $apiEntitiesContext["transformer"]((object) $extMedia)
        );
    }

    /**
     * @param array<string, string> $query
     */
    private function getAPIData(string $apiEntity, string $endPoint, array $query = []): mixed {
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
                if($error instanceof TMDBNotFoundError) return null;

                throw $error;
            }
            
            return $response->json();
        } catch(Exception $e) {
            if($e instanceof AppError) throw $e;

            throw new AppFailedTMDBApiRequest($e->getMessage());
        }
    }

    private function buildAppErrorFromAPIFailure(Response $response): AppError {
        $statusCode = $response->status();

        $failureBody = $response->json();
        /** @var TMDBError $tmdbError */
        $tmdbError = TMDBErrorTransformer::tryFromExternal((object) $failureBody);
        
        $tmdbCode = $tmdbError->getStatusCode();
        $tmdbErrorMessage = $tmdbError->getMessage();

        if($statusCode >= 500) return new TMDBInternalError($tmdbErrorMessage);

        switch($tmdbCode) {
            case TMDBError::NOT_FOUND:
                return new TMDBNotFoundError($tmdbErrorMessage);
            default:
                return new TMDBInternalError($tmdbErrorMessage);
        }
    }
}