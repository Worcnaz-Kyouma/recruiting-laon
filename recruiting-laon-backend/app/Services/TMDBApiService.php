<?php

namespace App\Services;

use App\Entities\Movie;
use App\Entities\TVSerie;
use App\Exceptions\AppFailedTMDBApiRequest;
use App\Transformers\TMDBApi\MovieTransformer;
use App\Transformers\TMDBApi\TVSerieTransformer;
use Http;
use Illuminate\Http\Client\Response;

/**
 * @template T of \App\Entities\Media
 */
class TMDBApiService {
    private string $baseUrl;
    private int $apiVersion;
    private string $apiKey;

    protected static array $appEntitiesToAPISemanticMap = [
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
    public function getPopularMedia(int $page = 1, bool $onlyTopMedia = false): array {
        $movies = $this->getPopularMediaGeneric(Movie::class, $page, $onlyTopMedia);
        $TVSeries = $this->getPopularMediaGeneric(TVSerie::class, $page, $onlyTopMedia);

        $medias = [
            "movies" => $movies,
            "TVSeries" => $TVSeries
        ];

        return $medias;
    }

    /**
     * @param class-string<T> $mediaType
     * @return array<T>
     */
    private function getPopularMediaGeneric(string $mediaType, int $page = 1, bool $onlyTopMedia = false): array {
        $apiSemantic = self::$appEntitiesToAPISemanticMap[$mediaType];
        
        $query = [
            "page" => $page
        ];
        $response = $this->fetchAPIData($apiSemantic["apiEntity"], "popular", $query);
        
        $data = $response->json();
        if($onlyTopMedia) {
            $numberOfTopMedias = 5;
            $data = array_slice($data, 0, $numberOfTopMedias);
        }
        $medias = collect($data)->map(fn($extMedia) => 
            $apiSemantic["transformer"]($extMedia)
        );

        return $medias->toArray();
    }

    /**
     * @param string[] $query
     */
    private function fetchAPIData(string $apiEntity, string $endPoint, array $query): Response {
        $defaultHeaders = [
            'Authorization' => $this->apiKey,
            'Accept'        => 'application/json',
        ];
        $defaultQuery = [
            'language' => 'en-US'
        ];

        $response = Http::withHeaders($defaultHeaders)->get(
            "$this->baseUrl/$this->apiVersion/$apiEntity/$endPoint", 
            array_merge($defaultQuery, $query)
        );
        if (!$response->successful()) 
            throw new AppFailedTMDBApiRequest();

        return $response;
    }
}