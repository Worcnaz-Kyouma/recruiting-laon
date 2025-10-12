<?php

namespace App\Entities;

class TVSeason {
    private int $tmbdId;
    private int $seasonNumber;
    private string $name;
    /**
     * @var TVEpisode[]
     */
    private array $episodes;
    public function __construct(array $data) {
        
    }
}
