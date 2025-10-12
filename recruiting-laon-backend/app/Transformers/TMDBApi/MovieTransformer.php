<?php

namespace App\Transformers\TMDBApi;

use App\Entities\Movie;
use stdClass;

class MovieTransformer {
    public static function fromExternal(stdClass $ext): Movie {
        $media = MediaTransformer::fromExternal($ext);

        $movie = new Movie($media);

        return $movie;
    }
}
