<?php

namespace App\Entities;

class MediaWorker extends Entity {
    private int $tmdbId;
    private string $name;
    
    public function __construct(int $tmdbId, string $name) {
        $this->tmdbId = $tmdbId;
        $this->name = $name;
    }

    public function jsonSerialize(): array {
        return [
            "tmdbId" => $this->tmdbId,
            "name" => $this->name
        ];
    }
}
