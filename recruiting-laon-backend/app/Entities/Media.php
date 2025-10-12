<?php

namespace App\Entities;

class Media {
    private string $title;
    private string $titlePortuguese;
    private string $durationStringfied;
    private string $overview;
    private Actor[] $actors;
    private Director $director;
    private float $review;

    public function __construct() {
                
    }
}
