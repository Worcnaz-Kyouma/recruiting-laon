<?php

namespace App\Http\Controllers;

use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Http\Requests\MediaDetailsRequest;
use App\Http\Requests\TVSeriesByListingMethodRequest;
use App\Services\TMDBApiService;

// TODO: If no results found in the requests, return error

// TODO: English or Portuguese app? Chose and dont change it
class TVSerieController extends Controller {
    private TMDBApiService $tmdb;

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getTVSeriesByListingMethod(TVSeriesByListingMethodRequest $request) {
        $data = $request->validated();

        $listingMethod = TVSerieListingMethod::tryFrom($data["listing_method"])
            ?? MediaListingMethod::tryFrom($data["listing_method"]);

        $tvSeries = $this->tmdb->getMediaByListingMethod(
            TVSerie::class,
            $listingMethod,
            $data["page"]
        )->toArray();

        return response()->json($tvSeries);
    }

    public function getTVSerieDetails(MediaDetailsRequest $request) {
        $data = $request->validated();

        $tvSerie = $this->tmdb->getMediaDetails($data["id"], TVSerie::class)->toArray();

        return response()->json($tvSerie);
    }
}
