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

    public function toArray(): array {
        return [
            "page" => $this->page,
            "numberOfPages" => $this->numberOfPages,
            "results" => $this->results
                ->map(fn(Entity $entity) => $entity->toArray())
                ->toArray()
        ];
    }
}
