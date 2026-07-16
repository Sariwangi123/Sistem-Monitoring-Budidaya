<?php

namespace Modules\Administration\Engines;

final class MonitoringEngine
{
    /** @return array<string, mixed> */
    public function health(): array
    {
        return ['read_only' => true, 'mode' => 'metadata_foundation', 'checks' => [
            ['key' => 'application', 'status' => 'ready'], ['key' => 'queue', 'status' => 'configured'],
            ['key' => 'cache', 'status' => 'configured'], ['key' => 'database', 'status' => 'configured'],
            ['key' => 'storage', 'status' => 'configured'],
        ]];
    }
}
