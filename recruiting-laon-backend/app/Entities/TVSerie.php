<?php

namespace App\Entities;

class TVSerie extends TMDBMedia {
    /**
     * @var array<TVSeason> | null
     */
    private ?array $seasons = null;

    /**
     * @param array<TVSeason> | null $summarizedSeasons
     */
    public function __construct(TMDBMedia $media, array $summarizedSeasons = []) {
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

        $this->seasons = $summarizedSeasons;
    }

    /**
     * @param array<TVSeason> $seasons
     */
    public function setSeasons(array $seasons): void {
        $this->seasons = $seasons;
        $this->buildDurationStringfied($seasons);
    }

    /**
     * @return array<TVSeason> $seasons
     */
    public function getSeasons(): array {
        return $this->seasons ?? [];
    }

    /**
     * @param array<TVSeason> $seasons
     */
    private function buildDurationStringfied(array $seasons): void {
        $numberOfSeasons = count($seasons);
        $numberOfEpisodes = collect($seasons)
            ->map(fn($s) => count($s->getEpisodes()))
            ->sum();

        $this->durationStringfied = 
            "$numberOfSeasons Temporada".($numberOfSeasons > 1 ? "s" : "") . ", " . 
            "$numberOfEpisodes Episódio".($numberOfEpisodes > 1 ? "s" : "");
    }

    public function jsonSerialize(): mixed {
        $media = parent::jsonSerialize();

        $media["seasons"] = $this->seasons
            ? array_map(fn($season) => $season->jsonSerialize(), $this->seasons)
            : null;

        return $media;
    }
}
