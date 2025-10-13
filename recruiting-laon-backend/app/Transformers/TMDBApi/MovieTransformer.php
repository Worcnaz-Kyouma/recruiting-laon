<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\Movie;
use stdClass;

// OBS to Code Reviewer: Genre, Actor and Director could receive its own Transformer, but i choose to keep it simple
class MovieTransformer extends MediaTransformer {
    public static function fromExternal(stdClass $ext): Movie {
        $tmdbId = $ext->id;
        $title = $ext->original_title;
        $titlePortuguese = self::titlePortugueseFromExternalTranslations($ext);
        $genres = self::genresFromExternal($ext);
        $overview = $ext->overview;
        $actors = self::actorsFromExternalCredits($ext);
        $directors = self::directorsFromExternalCredits($ext);
        $review = $ext->vote_average;
        $reviewCount = $ext->vote_count;
        $durationStringfied = isset($ext->runtime)
            ? self::durationStringfiedFromRuntime($ext->runtime)
            : null;

        $movie = new Movie(
            $tmdbId, $title, $titlePortuguese, $genres,
            $durationStringfied, $overview, $actors,
            $directors, $review, $reviewCount
        );

        return $movie;
    }

    private static function durationStringfiedFromRuntime(int $runtime): string {
        $hours = intdiv($runtime, 60);
        $minutes = $runtime % 60;

        $durationStringfied = ($hours ? "{$hours} Horas e " : "") . ($minutes ? "{$minutes} Minutos" : "");
        return trim($durationStringfied);
    }
}
