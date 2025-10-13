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
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use App\Http\DTO\PaginatedResultsDTO;
use App\Transformers\TMDBApi\MovieTransformer;
use App\Transformers\TMDBApi\TVSerieTransformer;
use Exception;
use Http;
use Illuminate\Http\Client\Response;

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
     * @return array {movies: PaginatedResultsDTO, TVSeries: PaginatedResultsDTO}
     */
    public function getTopPopularMedia(): array {
        $numberOfTopMedias = 5;

        $movies = $this->getMediaByListingMethods(Movie::class, MediaListingMethod::Popular, 1);
        $topMovies = $movies->results->take($numberOfTopMedias);

        $TVSeries = $this->getMediaByListingMethods(TVSerie::class, MediaListingMethod::Popular, 1);
        $topTVSeries = $TVSeries->results->take($numberOfTopMedias);

        $medias = [
            "movies" => $topMovies
                ->map(fn($m) => $m->toArray())
                ->toArray(),
            "TVSeries" => $topTVSeries
                ->map(fn($s) => $s->toArray())
                ->toArray()
        ];

        return $medias;
    }

    /**
     * @return PaginatedResultsDTO<Media>
     */
    public function getMediaByListingMethods(
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

    // TODO: The return here many times are pages, results. But for details not.... improve it, to returing a better typed result
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

    // User errors are not expected here, cause we gonna clear all users input, so if any response with status code > 400, its a unexpected error
    private function buildAppError(Response $response): AppError {
        throw new AppFailedTMDBApiRequest("TMDB API request failed with status {$response->status()} and body {$response->body()}");
    }
}