<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\TVSerie;
use stdClass;

class TVSerieTransformer extends MediaTransformer {
    public static function fromExternal(stdClass $ext): TVSerie {
        $media = parent::fromExternal($ext);

        $tvSerie = new TVSerie($media);

        return $tvSerie;
    }

    protected static function titleFromExternal(stdClass $ext): string {
        return $ext->original_name;
    }
}
