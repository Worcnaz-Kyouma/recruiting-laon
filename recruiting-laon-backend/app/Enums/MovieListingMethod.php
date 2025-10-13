<?php

namespace App\Enums;

enum MovieListingMethod: string {
    use ListingMethodHelpers;
    case Upcoming = 'upcoming';
}
