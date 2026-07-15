<?php

namespace ReportAnalytics\Services;

use Closure;
use Illuminate\Support\Facades\Cache;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;

final class ReportCacheService
{
    private const DEFAULT_TTL_SECONDS = 300;

    public function rememberMetadata(string $scope, array $context, Closure $callback, int $ttlSeconds = self::DEFAULT_TTL_SECONDS): mixed
    {
        return Cache::remember($this->key($scope, $context), $ttlSeconds, $callback);
    }

    public function key(string $scope, array $context): string
    {
        ksort($context);

        return 'report_analytics:'.$scope.':'.sha1(json_encode($context, JSON_THROW_ON_ERROR));
    }

    /** @return array<string, mixed> */
    public function requestContext(ReportDefinition $definition, ReportRequest $request): array
    {
        return [
            'user_id' => $request->userId,
            'company_id' => $request->parameters['filter']['company_id'] ?? null,
            'farm_id' => $request->parameters['filter']['farm_id'] ?? null,
            'report_id' => $definition->id,
            'filter' => $request->parameters['filter'] ?? [],
            'locale' => $request->locale,
            'format' => $request->format,
            'roles' => $request->roleSlugs,
        ];
    }
}
