<?php

namespace App\Http\DTO;


class ListingMethodDTO {
    public readonly string $value;
    public readonly string $description;

    public function __construct(string $value, string $description) {
        $this->value = $value;
        $this->description = $description;
    }
}
