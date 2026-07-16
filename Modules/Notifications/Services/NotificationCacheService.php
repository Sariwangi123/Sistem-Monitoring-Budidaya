<?php

namespace Modules\Notifications\Services;

use Illuminate\Support\Facades\Cache;

final class NotificationCacheService
{
    private const TTL_SECONDS = 300;

    /** @template T */
    public function registry(callable $resolver): array
    {
        return Cache::remember('notification:registry:v1', self::TTL_SECONDS, $resolver);
    }

    /** @template T */
    public function templates(callable $resolver): array
    {
        return Cache::remember('notification:templates:v1', self::TTL_SECONDS, $resolver);
    }

    /** @template T */
    public function overview(array $roles, callable $resolver): array
    {
        return Cache::remember($this->overviewKey($roles), self::TTL_SECONDS, $resolver);
    }

    /** @template T */
    public function statistics(string $userId, array $filters, callable $resolver): array
    {
        return Cache::remember($this->statisticsKey($userId, $filters), self::TTL_SECONDS, $resolver);
    }

    /** @template T */
    public function preference(string $userId, callable $resolver): mixed
    {
        return Cache::remember("notification:preference:{$userId}:{$this->userVersion($userId)}", self::TTL_SECONDS, $resolver);
    }

    public function forgetUser(string $userId): void
    {
        $key = "notification:user-cache-version:{$userId}";
        Cache::put($key, $this->userVersion($userId) + 1, self::TTL_SECONDS);
    }

    public function forgetStatistics(string $userId, array $filters = []): void
    {
        Cache::forget($this->statisticsKey($userId, $filters));
    }

    public function forgetRegistry(): void
    {
        Cache::forget('notification:registry:v1');
        Cache::forget('notification:templates:v1');
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return [
            'enabled' => true,
            'driver' => config('cache.default'),
            'ttl_seconds' => self::TTL_SECONDS,
            'scopes' => ['registry', 'template_metadata', 'preference_metadata', 'user_statistics', 'overview'],
            'stores_business_transactions' => false,
        ];
    }

    private function overviewKey(array $roles): string
    {
        sort($roles);

        return 'notification:overview:'.sha1(implode('|', $roles));
    }

    private function statisticsKey(string $userId, array $filters): string
    {
        ksort($filters);

        return "notification:statistics:{$userId}:{$this->userVersion($userId)}:".sha1(json_encode($filters) ?: '[]');
    }

    private function userVersion(string $userId): int
    {
        return (int) Cache::get("notification:user-cache-version:{$userId}", 1);
    }
}
