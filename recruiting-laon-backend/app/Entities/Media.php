<?php

namespace App\Entities;

class Media {
    protected int $tmbdId;
    protected string $title;
    protected ?string $titlePortuguese;
    /**
     * @var Genre[]
     */
    protected array $genres;
    protected string $durationStringfied;
    protected string $overview;
    /**
     * @var Actor[]
     */
    protected array $actors;
    /**
     * @var Director[]
     */
    protected array $directors;
    protected float $review;
    protected int $reviewCount;

    public function __construct(
        int $tmbdId, string $title, ?string $titlePortuguese,
        array $genres, string $overview, array $actors,
        array $directors, float $review, int $reviewCount
        ) {
        $this->tmbdId = $tmbdId;
        $this->title = $title;
        $this->titlePortuguese = $titlePortuguese;
        $this->genres = $genres;
        $this->overview = $overview;
        $this->actors = $actors;
        $this->directors = $directors;
        $this->review = $review;
        $this->reviewCount = $reviewCount;
    }
}
