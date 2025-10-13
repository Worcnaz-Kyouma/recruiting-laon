<?php

namespace App\Entities;

class Movie extends Media {
    public function __construct(int $tmbdId, string $title, ?string $titlePortuguese, ?array $genres,
        ?string $durationStringfied, string $overview, ?array $actors,
        ?array $directors, float $review, int $reviewCount
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
    }
}
