<?php

namespace App\Http\Controllers;

use App\Entities\Movie;
use App\Enums\MediaListingMethod;
use App\Enums\MovieListingMethod;
use App\Http\Requests\MediaDetailsRequest;
use App\Http\Requests\MoviesByListingMethodRequest;
use App\Services\TMDBApiService;

// TODO: If no results found in the requests, return error
class MovieController extends Controller {
    private TMDBApiService $tmdb;

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getMoviesByListingMethod(MoviesByListingMethodRequest $request) {
        $data = $request->validated();

        $listingMethod = MovieListingMethod::tryFrom($data["listing_method"])
            ?? MediaListingMethod::tryFrom($data["listing_method"]);

        $movies = $this->tmdb->getMediaByListingMethod(
            Movie::class,
            $listingMethod,
            $data["page"]
        )->toArray();

        return response()->json($movies);
    }

    public function getMovieDetails(MediaDetailsRequest $request) {
        $data = $request->validated();

        $movie = $this->tmdb->getMediaDetails($data["id"], Movie::class)->toArray();

        return response()->json($movie);
    }
}
