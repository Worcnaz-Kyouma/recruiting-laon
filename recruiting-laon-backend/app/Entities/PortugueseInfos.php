<?php

namespace App\Entities;

class PortugueseInfos extends Entity {
    private ?string $title;
    private ?string $overview;
    
    public function __construct(?string $title, ?string $overview) {
        $this->title = $title;
        $this->overview = $overview;
    }

    public function jsonSerialize(): array {
        return [
            "title" => $this->title,
            "overview" => $this->overview
        ];
    }
}
