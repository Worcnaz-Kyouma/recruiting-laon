<?php

namespace App\Transformers\TMDBApi;

use App\Entities\TVSerie;
use DateTime;

class TVSerieTransformer extends TMDBMediaTransformer {
    protected static function fromExternal(array $ext): TVSerie {
        $media = parent::fromExternal($ext);

        $summarizedSeasons = collect($ext["seasons"] ?? [])
            ->map(fn($ext) => TVSeasonTransformer::tryFromExternal($ext))
            ->toArray();

        $tvSerie = new TVSerie($media, $summarizedSeasons);

        return $tvSerie;
    }

    protected static function titleFromExternal(array $ext): string {
        return $ext['original_name'];
    }

    protected static function releaseDateFromExternal(array $ext): ?DateTime {
        return array_key_exists("first_air_date", $ext) && $ext["first_air_date"]
            ? new DateTime($ext["first_air_date"])
            : null;
    }

    protected static function titlePortugueseFromExternalTranslations(array $ext): ?string {
        if(!isset($ext['translations'])) return null;

        return data_get(
            collect($ext['translations']["translations"])->firstWhere("iso_3166_1", "BR"),
            'data.name'
        );
    }
}
