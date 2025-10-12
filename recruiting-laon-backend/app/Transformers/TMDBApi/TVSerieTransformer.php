<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Movie;
use App\Entities\TVSerie;
use stdClass;

class TVSerieTransformer {
    public static function fromExternal(stdClass $ext, ?stdClass $extSeasons = null): TVSerie {
        $media = MediaTransformer::fromExternal($ext);
        $seasons = $extSeasons 
            ? []
            : null;

        $tvSerie = new TVSerie($media, $seasons);

        return $tvSerie;
    }
}
