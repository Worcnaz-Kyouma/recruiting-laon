<?php

namespace App\Entities;

class TVSerie extends TMDBMedia {
    /**
     * @var array<TVSeason> | null
     */
    private ?array $seasons = null;

    // TODO: There's a way to improve that construct call?
    /**
     * @param array<TVSeason> | null $summarizedSeasons
     */
    public function __construct(TMDBMedia $media, array $summarizedSeasons = []) {
        parent::__construct(
            $media->tmdbId,
            $media->title,
            $media->titlePortuguese,
            $media->releaseDate,
            $media->genres,
            $media->overview,
            $media->actors,
            $media->directors,
            $media->review,
            $media->reviewCount,
            $media->posterImgUrl
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
        // Old duration calculation, i prefered to show number of seasons and episodes
        // $sumOfMinutesFromAllSeasons = collect($seasons)->map(fn($s) => 
        //     collect($s->getEpisodes())->sum(fn($e) => $e->getRuntime())
        // )->sum();

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
