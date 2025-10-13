<?php

namespace App\Http\Controllers;

use App\Exceptions\UnexpectedErrors\UnexpectedError;
use App\Services\TMDBApiService;
use Exception;
use Illuminate\Http\Request;

class MediaController extends Controller {
    private TMDBApiService $tmdb;

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getTopPopularMedias() {
        $medias = $this->tmdb->getTopPopularMedia();

        $mediasArrayParsed = [
            "movies" => $medias["movies"]
                ->map(fn($m) => $m->toArray())
                ->toArray(),
            "TVSeries" => $medias["TVSeries"]
                ->map(fn($s) => $s->toArray())
                ->toArray()
        ];

        return response()->json($mediasArrayParsed);
    }
}
