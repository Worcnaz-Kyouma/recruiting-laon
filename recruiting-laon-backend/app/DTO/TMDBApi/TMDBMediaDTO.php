<?php

namespace App\Entities;

class TMDBMediaDTO {
    public int $id;
    public array $genres;
    public string $originalTitle;
    public string $overview;
    
    
    public function __construct(array $data) {
        
    }
}
