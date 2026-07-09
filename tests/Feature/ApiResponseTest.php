<?php

namespace Tests\Feature;

use Tests\TestCase;

final class ApiResponseTest extends TestCase
{
    public function test_health_endpoint_is_available(): void
    {
        $this->get('/up')->assertOk();
    }
}
