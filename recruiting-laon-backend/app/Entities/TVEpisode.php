<?php

namespace App\Entities;

class TVEpisode extends Entity {
    private int $tmdbId;
    private ?int $episodeNumber = null;
    private ?string $name = null;
    private ?string $stillImageUrl = null; // Can be null?
    private int $runtime;
    public function __construct(int $tmdbId, ?int $episodeNumber, ?string $name, ?string $stillImageUrl, ?int $runtime) {
        $this->tmdbId = $tmdbId;
        $this->episodeNumber = $episodeNumber;
        $this->name = $name;
        $this->stillImageUrl = $stillImageUrl;
        $this->runtime = $runtime || 0;
    }

    public function getRuntime(): int {
        return $this->runtime;
    }

    public function jsonSerialize(): array {
        return [
            "tmdbId" => $this->tmdbId,
            "episodeNumber" => $this->episodeNumber,
            "name" => $this->name,
            "stillImageUrl" => $this->stillImageUrl,
            "runtime" => $this->runtime
        ];
    }
}
