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

    public function getTopPopularMedias(Request $request) {
        $medias = $this->tmdb->getTopPopularMedia();

        return response()->json($medias);
    }
}
