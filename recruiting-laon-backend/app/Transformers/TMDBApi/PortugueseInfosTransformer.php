<?php

namespace App\Transformers\TMDBApi;

use App\Entities\PortugueseInfos;
use App\Entities\TVEpisode;

class PortugueseInfosTransformer extends TMDBTransformer {
    protected static function fromExternal(array $ext): ?PortugueseInfos {
        if(!isset($ext['translations'])) return null;

        $extPortugueseInfos = collect($ext['translations']["translations"])
            ->firstWhere("iso_3166_1", "BR");
        if(!$extPortugueseInfos || 
            !array_key_exists("data", $extPortugueseInfos) || !$extPortugueseInfos["data"]
        ) 
            return null;

        $data = $extPortugueseInfos["data"];
        $title = array_key_exists("title", $data)
            ? $data["title"]
            : null;
        $overview = array_key_exists("overview", $data)
            ? $data["overview"]
            : null;

        $portugueseInfos = new PortugueseInfos($title, $overview);

        return $portugueseInfos;
    }
}
