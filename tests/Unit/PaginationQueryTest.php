<?php

namespace Tests\Unit;

use Core\DTO\PaginationQuery;
use PHPUnit\Framework\TestCase;

final class PaginationQueryTest extends TestCase
{
    public function test_it_normalizes_pagination_query(): void
    {
        $query = PaginationQuery::fromArray([
            'page' => '2',
            'per_page' => '250',
            'search' => 'pond',
            'sort' => 'name',
            'direction' => 'desc',
        ]);

        $this->assertSame(2, $query->page);
        $this->assertSame(100, $query->perPage);
        $this->assertSame('pond', $query->search);
        $this->assertSame('name', $query->sort);
        $this->assertSame('desc', $query->direction);
    }
}
