<?php

namespace Dashboard\Services;

use Dashboard\Exceptions\DashboardCacheException;
use Illuminate\Support\Facades\Cache;
use Throwable;

final class DashboardCacheService
{
    private const CACHE_INDEX_KEY = 'dashboard:cache_keys';

    public function remember(string $scope, array $roleSlugs, array $filters, callable $callback, ?int $ttlSeconds = null): array
    {
        try {
            $key = $this->key($scope, $roleSlugs, $filters);
            $cacheHit = Cache::has($key);
            $ttlSeconds ??= $this->ttlForScope($scope);

            $data = Cache::remember($key, $ttlSeconds, function () use ($key, $scope, $callback): array {
                $this->track($key, $scope);

                return $callback();
            });

            return [
                'data' => $data,
                'hit' => $cacheHit,
                'ttl_seconds' => $ttlSeconds,
                'key' => $key,
            ];
        } catch (Throwable $exception) {
            throw DashboardCacheException::operationFailed('remember', $exception);
        }
    }

    public function status(): array
    {
        try {
            $keys = Cache::get(self::CACHE_INDEX_KEY, []);

            return [
                'enabled' => true,
                'ttl_seconds' => $this->ttlForScope('default'),
                'tracked_keys' => count($keys),
            ];
        } catch (Throwable $exception) {
            throw DashboardCacheException::operationFailed('status', $exception);
        }
    }

    public function forget(?callable $predicate = null): void
    {
        try {
            $keys = Cache::get(self::CACHE_INDEX_KEY, []);

            foreach ($keys as $key => $scope) {
                if ($predicate === null || $predicate($key, $scope)) {
                    Cache::forget($key);
                    unset($keys[$key]);
                }
            }

            Cache::put(self::CACHE_INDEX_KEY, $keys, $this->ttlForScope('default'));
        } catch (Throwable $exception) {
            throw DashboardCacheException::operationFailed('forget', $exception);
        }
    }

    public function ttlForScope(string $scope): int
    {
        $criticalScopes = ['home', 'workspace', 'widgets'];
        $ttl = str_starts_with($scope, 'widget.') || in_array($scope, $criticalScopes, true)
            ? config('dashboard.cache.critical_ttl_seconds', 30)
            : config('dashboard.cache.ttl_seconds', 60);

        return max((int) $ttl, 1);
    }

    private function key(string $scope, array $roleSlugs, array $filters): string
    {
        ksort($filters);
        sort($roleSlugs);

        return 'dashboard:api:'.sha1(json_encode([
            'scope' => $scope,
            'roles' => $roleSlugs,
            'filters' => $filters,
        ], JSON_THROW_ON_ERROR));
    }

    private function track(string $key, string $scope): void
    {
        $keys = Cache::get(self::CACHE_INDEX_KEY, []);
        $keys[$key] = $scope;

        Cache::put(self::CACHE_INDEX_KEY, $keys, $this->ttlForScope('default'));
    }
}
