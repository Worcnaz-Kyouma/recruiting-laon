<?php

namespace App\Entities;

class TVSerie extends Media {
    /**
     * @var array<TVSeason> | null
     */
    private ?array $seasons;

    // TODO: There's a way to improve that construct call?
    /**
     * @param array<TVSeason> | null $seasons
     */
    public function __construct(Media $media, ?string $durationStringfied = null, ?array $seasons = null) {
        parent::__construct(
            $media->tmdbId,
            $media->title,
            $media->titlePortuguese,
            $media->genres,
            $media->overview,
            $media->actors,
            $media->directors,
            $media->review,
            $media->reviewCount
        );

        $this->durationStringfied = $durationStringfied;
        $this->seasons = $seasons;
    }
}
