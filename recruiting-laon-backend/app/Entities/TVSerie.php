<?php

namespace App\Entities;

class TVSerie extends Media {
    /**
     * @var array<TVSeason> | null
     */
    private ?array $seasons = null;

    // TODO: There's a way to improve that construct call?
    /**
     * @param array<TVSeason> | null $seasons
     */
    public function __construct(Media $media) {
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
    }

    /**
     * @param array<TVSeason> $seasons
     */
    public function setSeasons(array $seasons): void {
        $this->seasons = $seasons;
        $this->buildDurationStringfied($seasons);
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

    public function toArray(): array {
        $media = parent::toArray();

        $media["seasons"] = $this->seasons
            ? array_map(fn($season) => $season->toArray(), $this->seasons)
            : null;

        return $media;
    }
}
