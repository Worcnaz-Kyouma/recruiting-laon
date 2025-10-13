<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Media;
use App\Entities\Movie;
use stdClass;

class MovieTransformer extends MediaTransformer {
    public static function fromExternal(stdClass $ext): Movie {
        $media = parent::fromExternal($ext);

        $durationStringfied = isset($ext->runtime)
            ? self::durationStringfiedFromRuntime($ext->runtime)
            : null;

        $movie = new Movie($media, $durationStringfied);

        return $movie;
    }

    protected static function titleFromExternal(stdClass $ext): string {
        return $ext->original_title;
    }

    // TODO: If one hour, we need to remove the plural
    private static function durationStringfiedFromRuntime(int $runtime): string {
        $hours = intdiv($runtime, 60);
        $minutes = $runtime % 60;

        $durationStringfied = ($hours ? "{$hours} Horas e " : "") . ($minutes ? "{$minutes} Minutos" : "");
        return trim($durationStringfied);
    }
}
