<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TVEpisode;
use App\Entities\TVSeason;
use stdClass;

class TVEpisodeTransformer {
    public static function fromExternal(stdClass $ext): TVEpisode {
        $tmdbId = $ext->id;
        $episodeNumber = $ext->episode_number;
        $name = $ext->name;
        $tmdbImageBaseUrl = config('tmdb.image_base_url');
        $stillImageUrl = "$tmdbImageBaseUrl/$ext->still_path";
        $runtime = $ext->runtime;

        $tvEpisode = new TVEpisode(
            $tmdbId,
            $episodeNumber,
            $name,
            $stillImageUrl,
            $runtime
        );

        return $tvEpisode;
    }
}
