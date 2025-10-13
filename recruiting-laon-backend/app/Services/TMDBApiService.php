<?php

namespace App\Services;

use App\Entities\Media;
use App\Entities\Movie;
use App\Entities\TVSerie;
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

    private static array $appEntitiesToAPISemanticMap = [
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

    // TODO: We gonna remove all the specific popular methods, only that remaing to top 5 populars
    /**
     * @return array {movies: PaginatedResultsDTO, TVSeries: PaginatedResultsDTO}
     */
    public function getPopularMedia(int $page = 1, bool $onlyTopMedia = true): array {
        $movies = $this->getPopularMediaGeneric(Movie::class, $page, $onlyTopMedia);
        $TVSeries = $this->getPopularMediaGeneric(TVSerie::class, $page, $onlyTopMedia);

        $medias = [
            "movies" => $movies->toArray(),
            "TVSeries" => $TVSeries->toArray()
        ];

        return $medias;
    }

    // TODO: Complete refactor. Remove this popular specify and create generic ones, with ListingMethod(popular, incoming).
    // TODO: Search label -> search endpoint
    /**
     * @param class-string<T> $mediaType
     */
    private function getPopularMediaGeneric(string $mediaType, int $page = 1, bool $onlyTopMedia = false): PaginatedResultsDTO {
        $apiSemantic = self::$appEntitiesToAPISemanticMap[$mediaType];
        
        $query = [
            "page" => $page
        ];
        $response = $this->getAPIData($apiSemantic["apiEntity"], "popular", $query);
        
        $data = $response->json();
        $medias = collect($data["results"]);

        if($onlyTopMedia) {
            $numberOfTopMedias = 5;
            $medias = $medias->take($numberOfTopMedias);
        }

        $medias = $medias->map(fn($extMedia) => 
            $apiSemantic["transformer"]((object) $extMedia)
        );
        
        return new PaginatedResultsDTO(
            $data["page"],
            $data["total_pages"],
            $medias
        ); 
    }

    /**
     * @param array<string, string> $query
     */
    private function getAPIData(string $apiEntity, string $endPoint, array $query = []): Response {
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
            
            return $response;
        } catch(Exception $e) {
            if($e instanceof AppError) throw $e;

            throw new AppFailedTMDBApiRequest($e->getMessage());
        }
    }

    //TODO: If error 400-499, make client error, 500-599 server error
    private function buildAppError(Response $response): AppError {
        return new UnexpectedError("Api Error");
    }
}