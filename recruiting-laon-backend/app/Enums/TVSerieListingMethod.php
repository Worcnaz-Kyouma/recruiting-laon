<?php

namespace App\Enums;

enum TVSerieListingMethod: string {
    use ListingMethodHelpers;
    case OnTheAir = 'on_the_air';
}
