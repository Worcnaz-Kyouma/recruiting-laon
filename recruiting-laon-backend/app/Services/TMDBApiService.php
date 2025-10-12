<?php

namespace App\Services;

use App;
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
 * @template T of \App\Entities\Media
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

    /**
     * @return array {movies: array<T>, TVSeries: array<T>}
     */
    public function getPopularMedia(int $page = 1, bool $getExtraData = true, bool $onlyTopMedia = true): array {
        $movies = $this->getPopularMediaGeneric(Movie::class, $page, $getExtraData, $onlyTopMedia);
        $TVSeries = $this->getPopularMediaGeneric(TVSerie::class, $page, $getExtraData, $onlyTopMedia);

        $medias = [
            "movies" => $movies,
            "TVSeries" => $TVSeries
        ];

        return $medias;
    }

    // TODO: Maybe dont create a function only for popular, make it generic, and inside of it fetch popular, current playing and etc endpoints
    /**
     * @param class-string<T> $mediaType
     */
    private function getPopularMediaGeneric(string $mediaType, int $page = 1, bool $getExtraData = true, bool $onlyTopMedia = false): PaginatedResultsDTO {
        $apiSemantic = self::$appEntitiesToAPISemanticMap[$mediaType];
        
        $query = [
            "page" => $page
        ];
        if ($getExtraData) {
            $query["append_to_response"] = "translations,credits";
        }
        $response = $this->getAPIData($apiSemantic["apiEntity"], "popular", $query);
        
        $data = $response->json();
        $medias = collect($data["results"]);
        dd($medias);

        if($onlyTopMedia) {
            $numberOfTopMedias = 5;
            $medias = $medias->take($numberOfTopMedias);
        }

        $medias = $medias->map(fn($extMedia) => 
            $apiSemantic["transformer"]((object) $extMedia)
        );
        
        // TODO: Maybe create a DTO to it.
        return new PaginatedResultsDTO(
            $data["total_page"],
            $data["page"],
            $medias->toArray()
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

    //TODO
    private function buildAppError(Response $response): AppError {
        return new UnexpectedError("Api Error");
    }
}