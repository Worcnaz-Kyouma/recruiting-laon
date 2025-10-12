<?php

namespace App\Entities;

class MediaWorker {
    private int $tmbdId;
    private string $name;
    
    
    public function __construct(int $tmbdId, string $name) {
        $this->tmbdId = $tmbdId;
        $this->name = $name;
    }
}
