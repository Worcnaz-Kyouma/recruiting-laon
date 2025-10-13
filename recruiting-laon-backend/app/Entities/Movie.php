<?php

namespace App\Entities;

class Movie extends Media {
    // TODO: There's a way to improve that construct call?
    public function __construct(Media $media, ?string $durationStringfied = null) {
        parent::__construct(
            $media->tmdbId,
            $media->title,
            $media->titlePortuguese,
            $media->genres,
            $media->overview,
            $media->actors,
            $media->directors,
            $media->review,
            $media->reviewCount,
            $media->posterImgUrl
        );

        $this->durationStringfied = $durationStringfied;
    }
}
