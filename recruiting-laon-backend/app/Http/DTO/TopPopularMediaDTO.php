<?php

namespace App\Http\DTO;

use Illuminate\Support\Collection;
use App\Entities\Movie;
use App\Entities\TVSerie;

class TopPopularMediaDTO {
    /**
     * @var Collection<Movie>
     */
    public readonly Collection $movies;
    /**
     * @var Collection<TVSerie>
     */
    public readonly Collection $tvSeries;

    /**
     * @param Collection<Movie> $movies
     * @param Collection<TVSerie> $tvSeries
     */
    public function __construct(Collection $movies, Collection $tvSeries) {
        $this->movies = $movies;
        $this->tvSeries = $tvSeries;
    }
}
