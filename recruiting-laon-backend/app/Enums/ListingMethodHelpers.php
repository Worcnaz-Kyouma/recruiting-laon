<?php

namespace App\Enums;

use App\Http\DTO\ListingMethodDTO;
use Str;
trait ListingMethodHelpers {
    public static function values(): array {
        return array_map(fn($case) => 
            new ListingMethodDTO($case->value, Str::headline($case->name)),
            self::cases()
        );
    }
}