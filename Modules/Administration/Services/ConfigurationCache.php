<?php

namespace Modules\Administration\Services;

use Closure;
use Illuminate\Support\Facades\Cache;

final class ConfigurationCache
{
    private const TTL_SECONDS = 300;

    /** @param Closure(): array<int, array<string, mixed>> $resolver */
    public function registry(Closure $resolver): array
    {
        return Cache::remember('administration:configuration-registry:v1', self::TTL_SECONDS, $resolver);
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['enabled' => true, 'driver' => config('cache.default'), 'ttl_seconds' => self::TTL_SECONDS, 'stores_business_transactions' => false];
    }
}
