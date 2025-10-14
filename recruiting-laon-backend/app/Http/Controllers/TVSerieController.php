<?php

namespace App\Http\Controllers;

use App\Entities\TVSerie;
use App\Enums\MediaListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Http\Requests\MediaDetailsRequest;
use App\Http\Requests\MediasByTitleRequest;
use App\Http\Requests\TVSeriesByListingMethodRequest;
use App\Services\TMDBApiService;

class TVSerieController extends Controller {
    private TMDBApiService $tmdb;

    public function __construct(TMDBApiService $tmdb) {
        $this->tmdb = $tmdb;
    }

    public function getTVSeriesByListingMethod(TVSeriesByListingMethodRequest $request) {
        $data = $request->validated();
        $listingMethod = TVSerieListingMethod::tryFrom($data["listing-method"])
            ?? MediaListingMethod::tryFrom($data["listing-method"]);
        $page = $data["page"];

        $tvSeries = $this->tmdb->getMediasByListingMethod(
            TVSerie::class,
            $listingMethod,
            $page
        );

        return response()->json($tvSeries);
    }

    public function getTVSeriesByTitle(MediasByTitleRequest $request) {
        $data = $request->validated();
        $title = strip_tags(trim($data["title"]));
        $page = $data["page"];

        $tvSerie = $this->tmdb->getMediasByTitle(TVSerie::class, $title, $page);

        return response()->json($tvSerie);
    }

    public function getTVSerieDetails(MediaDetailsRequest $request) {
        $data = $request->validated();
        $id = $data["id"];

        $tvSerie = $this->tmdb->getMediaDetails($id, TVSerie::class);

        return response()->json($tvSerie);
    }
}