<?php

namespace App\Http\DTO;

/**
 * @template T
 */
class PaginatedResultsDTO {
    public readonly int $page;
    public readonly int $numberOfPages;
    /**
     * @var array<T>
     */
    public readonly array $results;

    /**
     * @param array<T> $results
     */
    public function __construct(int $page, int $numberOfPages, array $results) {
        $this->page = $page;
        $this->numberOfPages = $numberOfPages;
        $this->results = $results;
    }

}
