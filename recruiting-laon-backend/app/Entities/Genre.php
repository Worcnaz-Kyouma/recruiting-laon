<?php

namespace App\Entities;

class Genre extends Entity {
    private int $tmdbId;
    private string $name;
    public function __construct(int $tmdbId, string $name) {
        $this->tmdbId = $tmdbId;
        $this->name = $name;
    }

    public function toArray(): array {
        return [
            "tmdbId" => $this->tmdbId,
            "name" => $this->name
        ];
    }
}
