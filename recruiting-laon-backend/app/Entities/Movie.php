<?php

namespace App\Entities;

class Movie extends Media {
    public function __construct(Media $media) {
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
    }
}
