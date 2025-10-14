<?php

namespace App\Http\DTO;

use App\Entities\Entity;
use Illuminate\Support\Collection;

/**
 * @template T of Entity
 */
class PaginatedResultsDTO {
    public readonly int $page;
    public readonly int $numberOfPages;
    /**
     * @var Collection<T>
     */
    public readonly Collection $results;

    /**
     * @param Collection<T> $results
     */
    public function __construct(int $page, int $numberOfPages, Collection $results) {
        $this->page = $page;
        $this->numberOfPages = $numberOfPages;
        $this->results = $results;
    }

    public static function fromTMDBApiPaginatedResults(array $apiData, Collection $results): self {
        return new self(
            $apiData["page"],
            $apiData["total_pages"],
            $results
        );
    }

    public static function getEmptyPaginatedResults(): self {
        return new self(
            1,
            1,
            collect()
        );
    }
}
