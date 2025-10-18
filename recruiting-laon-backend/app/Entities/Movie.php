<?php

namespace App\Entities;

class Movie extends TMDBMedia {
    // TODO: There's a way to improve that construct call?
    public function __construct(TMDBMedia $media, ?string $durationStringfied = null) {
        parent::__construct(
            $media->tmdbId,
            $media->title,
            $media->releaseDate,
            $media->genres,
            $media->overview,
            $media->actors,
            $media->directors,
            $media->review,
            $media->reviewCount,
            $media->posterImgUrl,
            $media->youtubeTrailerVideoUrl,
            $media->portugueseInfos
        );

        $this->durationStringfied = $durationStringfied;
    }
}
