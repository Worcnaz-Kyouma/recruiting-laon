<?php

namespace App\Entities;

use DateTime;

class TMDBMedia extends Entity {
    protected int $tmdbId;
    protected string $title;
    protected ?string $titlePortuguese = null;
    protected ?DateTime $releaseDate = null;
    /**
     * @var array<Genre> | null
     */
    protected ?array $genres = null;
    protected ?string $durationStringfied = null;
    protected ?string $overview;
    /**
     * @var array<Actor> | null
     */
    protected ?array $actors = null;
    /**
     * @var array<Director> | null
     */
    protected ?array $directors = null;
    protected float $review;
    protected int $reviewCount;
    protected ?string $posterImgUrl;

    public function __construct(
        int $tmdbId, string $title, ?string $titlePortuguese, ?DateTime $releaseDate,
        ?array $genres, ?string $overview, ?array $actors,
        ?array $directors, float $review, int $reviewCount, ?string $posterImgUrl
    ) {
        $this->tmdbId = $tmdbId;
        $this->title = $title;
        $this->titlePortuguese = $titlePortuguese;
        $this->releaseDate = $releaseDate;
        $this->genres = $genres;
        $this->overview = $overview;
        $this->actors = $actors;
        $this->directors = $directors;
        $this->review = $review;
        $this->reviewCount = $reviewCount;
        $this->posterImgUrl = $posterImgUrl;
    }

    public function jsonSerialize(): mixed {
        return [
            "tmdbId" => $this->tmdbId,
            "title" => $this->title,
            "titlePortuguese" => $this->titlePortuguese,
            "releaseDate" => $this->releaseDate?->format('Y-m-d'),
            "genres" => $this->genres
                ? array_map(fn($genre) => $genre->jsonSerialize(), $this->genres)
                : null,
            "durationStringfied" => $this->durationStringfied,
            "overview" => $this->overview,
            "actors" => $this->actors
                ? array_map(fn($actor) => $actor->jsonSerialize(), $this->actors)
                : null,
            "directors" => $this->directors
                ? array_map(fn($director) => $director->jsonSerialize(), $this->directors)
                : null,
            "review" => $this->review,
            "reviewCount" => $this->reviewCount,
            "posterImgUrl" => $this->posterImgUrl
        ];
    }
}
