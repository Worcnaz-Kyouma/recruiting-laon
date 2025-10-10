<?php

namespace App\Services;

class TMDBApiService {
    private string $baseUrl;
    private int $apiVersion;
    private string $apiKey;
    
    public function __construct(
        string $baseUrl,
        int $apiVersion,
        string $apiKey
    ) {
        $this->baseUrl = $baseUrl;
        $this->apiVersion = $apiVersion;
        $this->apiKey = $apiKey;
    }
}