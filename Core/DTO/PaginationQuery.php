<?php

namespace Core\DTO;

final readonly class PaginationQuery
{
    public function __construct(
        public int $page = 1,
        public int $perPage = 15,
        public ?string $search = null,
        public ?string $sort = null,
        public string $direction = 'asc',
        public array $filters = [],
    ) {
    }

    public static function fromArray(array $payload): self
    {
        return new self(
            page: (int) ($payload['page'] ?? 1),
            perPage: min((int) ($payload['per_page'] ?? 15), 100),
            search: $payload['search'] ?? null,
            sort: $payload['sort'] ?? null,
            direction: $payload['direction'] ?? 'asc',
            filters: $payload['filters'] ?? [],
        );
    }
}
