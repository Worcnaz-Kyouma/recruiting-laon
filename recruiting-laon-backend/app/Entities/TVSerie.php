<?php

namespace App\Entities;

class TVSerie extends Media {
    /**
     * @var array<TVSeason> | null
     */
    private ?array $seasons;

    /**
     * @param array<TVSeason> | null $seasons
     */
    public function __construct(int $tmbdId, string $title, ?string $titlePortuguese, ?array $genres,
        ?string $durationStringfied, string $overview, ?array $actors,
        ?array $directors, float $review, int $reviewCount, ?array $seasons = null
    ) {
        parent::__construct(
            $tmbdId,
            $title,
            $titlePortuguese,
            $genres,
            $durationStringfied,
            $overview,
            $actors,
            $directors,
            $review,
            $reviewCount
        );

        $this->seasons = $seasons;
    }
}
