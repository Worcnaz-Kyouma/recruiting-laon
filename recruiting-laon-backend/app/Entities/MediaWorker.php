<?php

namespace App\Entities;

class MediaWorker extends Entity {
    private int $tmbdId;
    private string $name;
    
    
    public function __construct(int $tmbdId, string $name) {
        $this->tmbdId = $tmbdId;
        $this->name = $name;
    }

    public function toArray(): array {
        return [
            "tmbdId" => $this->tmbdId,
            "name" => $this->name
        ];
    }
}
