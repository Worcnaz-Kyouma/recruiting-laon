<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\TVSeason;
use App\Entities\TVSerie;
use stdClass;

class TVSeasonTransformer extends TMDBTransformer {
    protected static function fromExternal(stdClass $ext): TVSeason {
        $tmdbId = $ext->id;
        $seasonNumber = $ext->season_number;
        $name = $ext->name;
        $tmdbImageBaseUrl = config('tmdb.image_base_url');
        $posterImgUrl = "$tmdbImageBaseUrl/$ext->poster_path";
        $episodes = collect($ext->episodes)
            ->map(fn($ext) => TVEpisodeTransformer::tryFromExternal((object) $ext))
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
