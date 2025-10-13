<?php

namespace App\Entities;

class Media extends Entity {
    protected int $tmdbId;
    protected string $title;
    protected ?string $titlePortuguese;
    /**
     * @var array<Genre> | null
     */
    protected ?array $genres;
    protected ?string $durationStringfied;
    protected string $overview;
    /**
     * @var array<Actor> | null
     */
    protected ?array $actors;
    /**
     * @var array<Director> | null
     */
    protected ?array $directors;
    protected float $review;
    protected int $reviewCount;

    public function __construct(
        int $tmdbId, string $title, ?string $titlePortuguese, 
        ?array $genres, string $overview, ?array $actors,
        ?array $directors, float $review, int $reviewCount
    ) {
        $this->tmdbId = $tmdbId;
        $this->title = $title;
        $this->titlePortuguese = $titlePortuguese;
        $this->genres = $genres;
        $this->overview = $overview;
        $this->actors = $actors;
        $this->directors = $directors;
        $this->review = $review;
        $this->reviewCount = $reviewCount;
    }

    public function toArray(): array {
        return [
            "tmdbId" => $this->tmdbId,
            "title" => $this->title,
            "titlePortuguese" => $this->titlePortuguese,
            "genres" => $this->genres
                ? array_map(fn($genre) => $genre->toArray(), $this->genres)
                : null,
            "durationStringfied" => $this->durationStringfied,
            "overview" => $this->overview,
            "actors" => $this->actors
                ? array_map(fn($actor) => $actor->toArray(), $this->actors)
                : null,
            "directors" => $this->directors
                ? array_map(fn($director) => $director->toArray(), $this->directors)
                : null,
            "review" => $this->review,
            "reviewCount" => $this->reviewCount
        ];
    }
}
