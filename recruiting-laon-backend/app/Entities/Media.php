<?php

namespace App\Entities;

class Media {
    private int $tmbdId;
    private string $title;
    private string $titlePortuguese;
    /**
     * @var Genre[]
     */
    private array $genres;
    private string $durationStringfied;
    private string $overview;
    /**
     * @var Actor[]
     */
    private array $actors = [];
    private Director $director;
    private float $review;

    public function __construct() {
    }
}
