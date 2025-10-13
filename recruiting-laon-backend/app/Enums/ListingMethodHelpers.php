<?php

namespace App\Enums;
trait ListingMethodHelpers {
    public static function values(): array {
        return array_map(fn($case) => $case->value, self::cases());
    }
}