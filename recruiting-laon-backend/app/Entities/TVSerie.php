<?php

namespace App\Entities;

class TVSerie extends Media {
    /**
     * @var TVSeason[] | null
     */
    private ?array $seasons;

    /**
     * @param TVSeason[] | null $seasons
     */
    public function __construct(Media $media, ?array $seasons = null) {
        parent::__construct(
            $media->tmbdId,
            $media->title,
            $media->titlePortuguese,
            $media->genres,
            $media->overview,
            $media->actors,
            $media->directors,
            $media->review,
            $media->reviewCount
        );

        $this->seasons = $seasons;
    }
}
