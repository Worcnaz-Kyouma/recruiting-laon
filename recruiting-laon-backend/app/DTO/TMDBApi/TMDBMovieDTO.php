<?php

namespace App\Entities;

class TMDBMovieDTO extends TMDBMediaDTO {
    public int $id;
    public string $name;
    
    
    public function __construct(array $data) {
        
    }
}
