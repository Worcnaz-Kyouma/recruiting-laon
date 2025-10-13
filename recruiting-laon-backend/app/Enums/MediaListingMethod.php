<?php

namespace App\Enums;

enum MediaListingMethod: string {
    use ListingMethodHelpers;
    case Popular = 'popular';
    case TopRated = 'top_rated';
    case Trending = 'trending';
}
