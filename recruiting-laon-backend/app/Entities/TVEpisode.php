<?php

namespace App\Entities;

class TVEpisode {
    private int $tmdbId;
    private string $name;
    private string $coverImageUrl;
    public function __construct(array $data) {
        
    }
}
