<?php

namespace App\Entities;

class TVSerie extends Media {
    /**
     * @var TVSeason[]
     */
    private array $seasons;
    public function __construct(array $data) {
        
    }
}
