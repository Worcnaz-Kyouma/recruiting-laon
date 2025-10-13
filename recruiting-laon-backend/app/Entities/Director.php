<?php

namespace App\Entities;

class Director extends MediaWorker {
    public function __construct(int $tmdbId, string $name) {
        parent::__construct($tmdbId, $name);
    }
}
