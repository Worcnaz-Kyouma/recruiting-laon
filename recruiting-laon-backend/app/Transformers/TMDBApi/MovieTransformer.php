<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Movie;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;

class MovieTransformer extends MediaTransformer {
    protected static function fromExternal(array $ext): Movie {
        $media = parent::fromExternal($ext);

        $durationStringfied = isset($ext['runtime'])
            ? self::durationStringfiedFromRuntime($ext['runtime'])
            : null;

        $movie = new Movie($media, $durationStringfied);

        return $movie;
    }

    private static function durationStringfiedFromRuntime(int $runtime): string {
        CarbonInterval::setLocale('pt');

        $interval = CarbonInterval::minutes($runtime)->cascade();

        $durationStringfied = $interval->forHumans([
            'short'  => false,
            'parts'  => 2,
            'join'   => ' e ',
            'syntax' => CarbonInterface::DIFF_ABSOLUTE,
        ]);

        return $durationStringfied;
    }
}
