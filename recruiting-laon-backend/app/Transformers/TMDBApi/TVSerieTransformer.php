<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\TVSerie;
use stdClass;

// OBS to Code Reviewer: Genre, Actor and Director could receive its own Transformer, but i choose to keep it simple
class TVSerieTransformer extends MediaTransformer {
    public static function fromExternal(stdClass $ext, ?stdClass $extSeasons = null): TVSerie {
        $media = parent::fromExternal($ext);

        $seasons = $extSeasons 
            ? []
            : null;
        
        $durationStringfied = $extSeasons
            ? ""
            : null;

        $tvSerie = new TVSerie($media, $durationStringfied, $seasons);

        return $tvSerie;
    }

    protected static function titleFromExternal(stdClass $ext): string {
        return $ext->original_name;
    }
}
