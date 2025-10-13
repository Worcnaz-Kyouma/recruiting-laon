<?php

namespace App\Services;

use App\Entities\Media;
use App\Entities\Movie;
use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\AppError;
use App\Exceptions\UnexpectedErrors\AppFailedTMDBApiRequest;
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
            'transformer' => [MovieTransformer::class, "fromExternal"],
        ],
        TVSerie::class => [
            'apiEntity' => 'tv',
            'transformer' => [TVSerieTransformer::class, "fromExternal"]
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

        $movies = $this->getMediaByListingMethod(Movie::class, MediaListingMethod::Popular, 1);
        $topMovies = $movies->results->take($numberOfTopMedias);

        $TVSeries = $this->getMediaByListingMethod(TVSerie::class, MediaListingMethod::Popular, 1);
        $topTVSeries = $TVSeries->results->take($numberOfTopMedias);

        $medias = [
            "movies" => $topMovies,
            "TVSeries" => $topTVSeries
        ];

        return $medias;
    }

    /**
     * @return PaginatedResultsDTO<Media>
     */
    public function getMediaByListingMethod(
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

        $medias = collect($data["results"])->map(fn($extMedia) => 
            $apiEntitiesContext["transformer"]((object) $extMedia)
        );

        return new PaginatedResultsDTO(
            $data["page"],
            $data["total_pages"],
            $medias
        );
    }

    public function getMediaDetails(int $tmdbId, string $mediaType): Media {
        $apiEntitiesContext = self::$appEntitiesToAPIEntitiesContextMap[$mediaType];

        $data = $this->getAPIData(
            $apiEntitiesContext["apiEntity"], 
            $tmdbId,
            ["append_to_response" => "translations,credits"]
        );

        $media = $apiEntitiesContext["transformer"]((object) $data);

        if($mediaType === TVSerie::class) {
            $seasons = collect($data["seasons"])->map(function($ext) use ($tmdbId) {
                $seasonNumber = $ext["season_number"];
                $seasonData = $this->getAPIData(
                    "tv", 
                    "$tmdbId/season/$seasonNumber"
                );

                return TVSeasonTransformer::fromExternal((object) $seasonData);
            })->toArray();

            $media->setSeasons($seasons);
        }

        return $media;
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
                $error = $this->buildAppError($response);
                throw $error;
            }
            
            return $response->json();
        } catch(Exception $e) {
            if($e instanceof AppError) throw $e;

            throw new AppFailedTMDBApiRequest($e->getMessage());
        }
    }

    // TODO: Improve it, cause they gonna it as API too, not only the front-end interface
    private function buildAppError(Response $response): AppError {
        throw new AppFailedTMDBApiRequest("TMDB API request failed with status {$response->status()} and body {$response->body()}");
    }
}