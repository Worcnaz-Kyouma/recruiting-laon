<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TVSeason;

class TVSeasonTransformer extends TMDBTransformer {
    protected static function fromExternal(array $ext): TVSeason {
        $tmdbId = $ext['id'];
        $seasonNumber = $ext['season_number'];
        $name = $ext['name'];
        $tmdbImageBaseUrl = config('tmdb.image_base_url');
        $posterImgUrl = "$tmdbImageBaseUrl/{$ext['poster_path']}";
        $episodes = collect($ext['episodes'])
            ->map(fn($ext) => TVEpisodeTransformer::tryFromExternal($ext))
            ->toArray();

        $tvSeason = new TVSeason(
            $tmdbId,
            $seasonNumber,
            $name,
            $posterImgUrl,
            $episodes
        );

        return $tvSeason;
    }
}
