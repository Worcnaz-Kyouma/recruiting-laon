<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\TVSerie;
use stdClass;

// OBS to Code Reviewer: Genre, Actor and Director could receive its own Transformer, but i choose to keep it simple
class TVSerieTransformer extends MediaTransformer {
    public static function fromExternal(stdClass $ext, ?stdClass $extSeasons = null): TVSerie {
        $tmdbId = $ext->id;
        $title = $ext->original_name;
        $titlePortuguese = self::titlePortugueseFromExternalTranslations($ext);
        $genres = self::genresFromExternal($ext);
        $overview = $ext->overview;
        $actors = self::actorsFromExternalCredits($ext);
        $directors = self::directorsFromExternalCredits($ext);
        $review = $ext->vote_average;
        $reviewCount = $ext->vote_count;

        $seasons = $extSeasons 
            ? []
            : null;
        
        $durationStringfied = $extSeasons
            ? ""
            : null;

        $tvSerie = new TVSerie(
            $tmdbId, $title, $titlePortuguese, $genres,
            $durationStringfied, $overview, $actors,
            $directors, $review, $reviewCount, $seasons
        );

        return $tvSerie;
    }
}
