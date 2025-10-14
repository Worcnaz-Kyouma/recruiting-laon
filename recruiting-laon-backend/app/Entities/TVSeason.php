<?php

namespace App\Entities;

class TVSeason extends Entity {
    private int $tmdbId;
    private int $seasonNumber;
    private string $name;
    private string $posterImgUrl;
    /**
     * @var array<TVEpisode>
     */
    private array $episodes;

    /**
     * @param array<TVEpisode> $episodes
     */
    public function __construct(int $tmdbId, int $seasonNumber, string $name, string $posterImgUrl, array $episodes) {
        $this->tmdbId = $tmdbId;
        $this->seasonNumber = $seasonNumber;
        $this->name = $name;
        $this->episodes = $episodes;
        $this->posterImgUrl = $posterImgUrl;
    }

    /**
     * @return array<TVEpisode>
     */
    public function getEpisodes(): array {
        return $this->episodes;
    }

    public function jsonSerialize(): array {
        return [
            "tmdbId" => $this->tmdbId,
            "seasonNumber" => $this->seasonNumber,
            "name" => $this->name,
            "posterImgUrl" => $this->posterImgUrl,
            "episodes" => array_map(fn($episode) => $episode->jsonSerialize(), $this->episodes)
        ];
    }
}
