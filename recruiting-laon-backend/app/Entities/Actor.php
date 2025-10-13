<?php

namespace App\Entities;

class Actor extends MediaWorker {
    public function __construct(int $tmdbId, string $name) {
        parent::__construct($tmdbId, $name);
    }
}
