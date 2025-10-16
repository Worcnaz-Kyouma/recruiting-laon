<?php

namespace App\Http\Controllers;

use App\Enums\MediaListingMethod;
use App\Enums\MediaType;
use App\Enums\MovieListingMethod;
use App\Enums\TVSerieListingMethod;
use App\Exceptions\UnexpectedErrors\UnexpectedError;
use App\Http\Requests\ListingMethodsRequest;
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

        return response()->json($medias);
    }

    public function getListingMethods(ListingMethodsRequest $request) {
        $data = $request->validated();
        $mediaType = $data["media_type"];

        $genericListingMethods = collect(MediaListingMethod::values());
        $extraListingMethods = collect($mediaType === MediaType::Movie->value
            ? MovieListingMethod::values()
            : TVSerieListingMethod::values()
        );
        $listingMethods = $genericListingMethods->merge($extraListingMethods);

        return response()->json($listingMethods);
    }
}
