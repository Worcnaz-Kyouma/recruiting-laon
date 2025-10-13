<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\TVSerie;
use stdClass;

class TVSerieTransformer extends MediaTransformer {
    protected static function fromExternal(stdClass $ext): TVSerie {
        $media = parent::fromExternal($ext);

        $tvSerie = new TVSerie($media);

        return $tvSerie;
    }

    protected static function titleFromExternal(stdClass $ext): string {
        return $ext->original_name;
    }
    
    protected static function titlePortugueseFromExternalTranslations(stdClass $ext): ?string {
        if(!isset($ext->translations)) return null;

        return data_get(
            collect($ext->translations["translations"])->firstWhere("iso_3166_1", "BR"),
            'data.name'
        );
    }
}
