<?php

namespace App\Http\Controllers;

use App\Entities\Movie;
use App\Enums\MediaListingMethod;
use App\Enums\MovieListingMethod;
use App\Http\Requests\MediaDetailsRequest;
use App\Http\Requests\MediasByTitleRequest;
use App\Http\Requests\MoviesByListingMethodRequest;
use App\Services\TMDBApiService;

class MovieController extends Controller {
    private TMDBApiService $tmdb;

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getMoviesByListingMethod(MoviesByListingMethodRequest $request) {
        $data = $request->validated();
        $listingMethod = MovieListingMethod::tryFrom($data["listing_method"])
            ?? MediaListingMethod::tryFrom($data["listing_method"]);
        $page = $data["page"];

        $movies = $this->tmdb->getMediasByListingMethod(
            Movie::class,
            $listingMethod,
            $page
        );

        return response()->json($movies);
    }

    public function getMoviesByTitle(MediasByTitleRequest $request) {
        $data = $request->validated();
        $title = strip_tags(trim($data["title"]));
        $page = $data["page"];
        
        $movie = $this->tmdb->getMediasByTitle(Movie::class, $title, $page);

        return response()->json($movie);
    }

    public function getMovieDetails(MediaDetailsRequest $request) {
        $data = $request->validated();
        $id = $data["id"];

        $movie = $this->tmdb->getMediaDetails($id, Movie::class);

        return response()->json($movie);
    }
}