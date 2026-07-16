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

    public function ttl(): int
    {
        return self::TTL_SECONDS;
    }

    public function forgetRegistry(): void
    {
        Cache::forget('administration:configuration-registry:v1');
    }

    public function forgetConfiguration(string $category): void
    {
        Cache::forget("administration:configuration:{$category}");
    }

    public function userKey(string $scope, string $userId): string
    {
        return "administration:{$scope}:user:{$userId}";
    }

    public function moduleKey(): string
    {
        return 'administration:module-registry:v1';
    }

    public function featureKey(string $feature): string
    {
        return "administration:feature-toggle:{$feature}";
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['enabled' => true, 'driver' => config('cache.default'), 'ttl_seconds' => self::TTL_SECONDS, 'stores_business_transactions' => false, 'invalidation' => 'configuration_and_feature_update', 'scopes' => ['configuration', 'module', 'feature', 'user']];
    }
}
