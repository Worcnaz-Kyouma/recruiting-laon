<?php

namespace App\Entities;

class TVEpisode {
    private int $tmdbId;
    private int $episodeNumber;
    private string $name;
    private string $stillImageUrl;
    private int $runtime;
    public function __construct(int $tmdbId, int $episodeNumber, string $name, string $stillImageUrl, int $runtime) {
        $this->tmdbId = $tmdbId;
        $this->episodeNumber = $episodeNumber;
        $this->name = $name;
        $this->stillImageUrl = $stillImageUrl;
        $this->runtime = $runtime;
    }

    public function getRuntime(): int {
        return $this->runtime;
    }
}
