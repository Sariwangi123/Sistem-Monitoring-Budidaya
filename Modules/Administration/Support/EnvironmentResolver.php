<?php

namespace Modules\Administration\Support;

final class EnvironmentResolver
{
    /** @return array<string, mixed> */
    public function resolve(): array
    {
        return ['environment' => app()->environment(), 'debug' => config('app.debug'), 'cache_driver' => config('cache.default'), 'queue_driver' => config('queue.default'), 'database_connection' => config('database.default')];
    }
}
