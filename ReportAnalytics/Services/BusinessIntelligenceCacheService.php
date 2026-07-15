<?php

namespace ReportAnalytics\Services;

use Closure;

final class BusinessIntelligenceCacheService
{
    public function __construct(private ReportCacheService $cacheService)
    {
    }

    public function remember(string $scope, array $context, Closure $callback): mixed
    {
        return $this->cacheService->rememberMetadata("bi.part6.{$scope}", $context, $callback, (int) config('cache.report_analytics_bi_ttl', 300));
    }

    public function metadata(string $scope, array $context): array
    {
        return [
            'enabled' => true,
            'scope' => $scope,
            'key' => $this->cacheService->key("bi.part6.{$scope}", $context),
            'ttl_seconds' => (int) config('cache.report_analytics_bi_ttl', 300),
            'scoped_by' => ['user', 'company', 'farm', 'period', 'permission'],
        ];
    }
}
