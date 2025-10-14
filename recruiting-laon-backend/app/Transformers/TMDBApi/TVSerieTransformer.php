<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TVSerie;

class TVSerieTransformer extends MediaTransformer {
    protected static function fromExternal(array $ext): TVSerie {
        $media = parent::fromExternal($ext);

        $tvSerie = new TVSerie($media);

        return $tvSerie;
    }

    protected static function titleFromExternal(array $ext): string {
        return $ext['original_name'];
    }

    protected static function titlePortugueseFromExternalTranslations(array $ext): ?string {
        if(!isset($ext['translations'])) return null;

        return data_get(
            collect($ext['translations']["translations"])->firstWhere("iso_3166_1", "BR"),
            'data.name'
        );
    }
}
