<?php

namespace App\Services;

use Http;
use Illuminate\Http\Client\Response;

/**
 * @template T of Media
 */
class TMDBApiService {
    private string $baseUrl;
    private int $apiVersion;
    private string $apiKey;

    protected static array $localEntitiesToAPIEntitiesMap = [
        Movie::class => 'movie',
        TVShow::class => 'tvshow'
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
     * @return array<T>
     */
    public function getPopularMedia(): array {
        $movies = $this->getPopularMedia(Movie::class);
        $tvShows = $this->getPopularMedia(TVShow::class);

        $medias = array_merge($movies, $tvShows);

        return $medias;
    }

    /**
     * @param class-string<T> $mediaType
     * @return array<T>
     */
    private function getPopularMediaGeneric(string $mediaType): array {
        $apiEntity = self::$localEntitiesToAPIEntitiesMap[$mediaType];
        
        $response = $this->fetchAPIData($apiEntity, "popular", []);
        
        $data = $response->json();
        return $data;
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
            throw new \Exception('Something went wrong!');

        return $response;
    }
}