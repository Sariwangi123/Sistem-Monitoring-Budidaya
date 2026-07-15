<?php

namespace Dashboard\Services;

use Dashboard\Engines\DashboardEngine;
use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Widgets\Support\WidgetDefinition;
use Dashboard\Widgets\WidgetRegistry;
use Dashboard\Workspaces\DashboardWorkspace;
use Dashboard\Workspaces\DashboardWorkspaceResolver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

final class DashboardService
{
    private const CACHE_TTL_SECONDS = 60;
    private const CACHE_INDEX_KEY = 'dashboard:cache_keys';

    public function __construct(
        private DashboardRepositoryInterface $repository,
        private DashboardEngine $dashboardEngine,
        private WidgetRegistry $widgetRegistry,
        private DashboardWorkspaceResolver $workspaceResolver
    )
    {
    }

    public function getOperationalSnapshot(int $perPage = 15): array
    {
        return $this->repository->getOperationalSnapshot($perPage);
    }

    public function getWorkspace(
        array $roleSlugs,
        ?string $requestedWorkspace = null,
        int $perPage = 15
    ): DashboardWorkspace {
        return $this->dashboardEngine->buildWorkspace(
            $this,
            $roleSlugs,
            $requestedWorkspace,
            $perPage
        );
    }

    public function home(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('home', $roleSlugs, $filters, function () use ($roleSlugs, $filters): array {
            $workspace = $this->getWorkspace(
                $roleSlugs,
                $filters['workspace'] ?? null,
                $this->perPage($filters)
            );

            return [
                'workspace' => $this->workspaceData($workspace),
                'widgets' => $this->widgetContainersData($workspace->containers),
                'kpi' => [],
                'alerts' => [],
            ];
        });
    }

    public function workspacePayload(string $workspace, array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse("workspace.{$workspace}", $roleSlugs, $filters, function () use ($workspace, $roleSlugs, $filters): array {
            $dashboardWorkspace = $this->getWorkspace($roleSlugs, $workspace, $this->perPage($filters));

            return $this->workspaceData($dashboardWorkspace);
        });
    }

    public function kpi(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('kpi', $roleSlugs, $filters, fn (): array => [
            'workspace' => $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs),
            'items' => [],
            'trend' => [],
            'comparison' => [],
        ]);
    }

    public function widgets(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('widgets', $roleSlugs, $filters, function () use ($roleSlugs, $filters): array {
            $workspace = $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs);

            return [
                'workspace' => $workspace,
                'items' => array_values(array_map(
                    fn ($widget): array => $this->widgetDefinitionData($widget->definition()),
                    $this->widgetRegistry->forWorkspace($workspace)
                )),
            ];
        });
    }

    public function widgetDetail(string $widgetKey): ?array
    {
        $widget = $this->widgetRegistry->find($widgetKey);

        return $widget ? $this->widgetDefinitionData($widget->definition()) : null;
    }

    public function refreshWidget(string $widgetKey, array $roleSlugs, array $filters): ?WidgetContainer
    {
        $this->forgetCache(fn (string $key, string $scope): bool => $scope === 'widgets' || str_contains($scope, "widget.{$widgetKey}"));

        return $this->dashboardEngine->refreshWidget($this, $widgetKey, $roleSlugs, $this->perPage($filters));
    }

    public function alerts(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('alerts', $roleSlugs, $filters, fn (): array => [
            'items' => [],
            'priority' => [],
            'status' => [
                'unread_only' => (bool) ($filters['unread_only'] ?? false),
                'severity' => $filters['severity'] ?? null,
                'category' => $filters['category'] ?? null,
            ],
        ]);
    }

    public function timeline(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('timeline', $roleSlugs, $filters, fn (): array => [
            'recent_activities' => [],
            'harvest_events' => [],
            'inventory_events' => [],
            'financial_events' => [],
        ]);
    }

    public function analytics(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('analytics', $roleSlugs, $filters, fn (): array => [
            'workspace' => $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs),
            'summary' => [],
            'trend' => [],
            'comparison' => [],
        ]);
    }

    public function refreshDashboard(array $roleSlugs, array $filters): array
    {
        $workspace = $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs);
        $this->forgetCache(fn (string $key, string $scope): bool => str_contains($scope, "workspace.{$workspace}") || $scope === 'home');

        return [
            'data' => [
                'workspace' => $workspace,
                'cache_cleared' => true,
            ],
            'message' => 'Dashboard cache refreshed.',
            'meta' => [
                'cache_status' => 'cleared',
            ],
        ];
    }

    public function cacheStatus(): array
    {
        $keys = Cache::get(self::CACHE_INDEX_KEY, []);

        return [
            'data' => [
                'enabled' => true,
                'ttl_seconds' => self::CACHE_TTL_SECONDS,
                'tracked_keys' => count($keys),
            ],
            'message' => 'Dashboard cache status retrieved.',
            'meta' => [
                'cache_status' => 'live',
            ],
        ];
    }

    public function clearCache(): array
    {
        $this->forgetCache();

        return [
            'data' => [
                'cache_cleared' => true,
            ],
            'message' => 'Dashboard cache cleared.',
            'meta' => [
                'cache_status' => 'cleared',
            ],
        ];
    }

    public function statistics(): array
    {
        $widgets = $this->widgetRegistry->all();

        return [
            'data' => [
                'total_widget' => count($widgets),
                'active_widget' => count($widgets),
                'dashboard_load_time' => null,
                'cache_hit_ratio' => null,
            ],
            'message' => 'Dashboard statistics retrieved.',
            'meta' => [
                'cache_status' => 'live',
            ],
        ];
    }

    public function export(array $roleSlugs, array $filters): array
    {
        return [
            'data' => [
                'format' => $filters['format'],
                'workspace' => $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs),
                'status' => 'Queued',
            ],
            'message' => 'Dashboard export request accepted.',
            'meta' => [
                'cache_status' => 'not_applicable',
            ],
        ];
    }

    private function cachedResponse(string $scope, array $roleSlugs, array $filters, callable $callback): array
    {
        $startedAt = microtime(true);
        $key = $this->cacheKey($scope, $roleSlugs, $filters);
        $cacheHit = Cache::has($key);
        $data = Cache::remember($key, self::CACHE_TTL_SECONDS, function () use ($key, $scope, $callback): array {
            $this->trackCacheKey($key, $scope);

            return $callback();
        });

        $meta = [
            'cache_status' => $cacheHit ? 'hit' : 'miss',
            'execution_time_ms' => round((microtime(true) - $startedAt) * 1000, 2),
            'cache_ttl_seconds' => self::CACHE_TTL_SECONDS,
        ];

        Log::info('dashboard.endpoint.executed', [
            'scope' => $scope,
            'roles' => $roleSlugs,
            'workspace' => $filters['workspace'] ?? null,
            'execution_time_ms' => $meta['execution_time_ms'],
            'cache_status' => $meta['cache_status'],
        ]);

        return [
            'data' => $data,
            'message' => 'Success',
            'meta' => $meta,
        ];
    }

    private function cacheKey(string $scope, array $roleSlugs, array $filters): string
    {
        ksort($filters);
        sort($roleSlugs);

        return 'dashboard:api:'.sha1(json_encode([
            'scope' => $scope,
            'roles' => $roleSlugs,
            'filters' => $filters,
        ], JSON_THROW_ON_ERROR));
    }

    private function trackCacheKey(string $key, string $scope): void
    {
        $keys = Cache::get(self::CACHE_INDEX_KEY, []);
        $keys[$key] = $scope;

        Cache::put(self::CACHE_INDEX_KEY, $keys, self::CACHE_TTL_SECONDS);
    }

    private function forgetCache(?callable $predicate = null): void
    {
        $keys = Cache::get(self::CACHE_INDEX_KEY, []);

        foreach ($keys as $key => $scope) {
            if ($predicate === null || $predicate($key, $scope)) {
                Cache::forget($key);
                unset($keys[$key]);
            }
        }

        Cache::put(self::CACHE_INDEX_KEY, $keys, self::CACHE_TTL_SECONDS);
    }

    private function workspaceData(DashboardWorkspace $workspace): array
    {
        return [
            'workspace' => [
                'key' => $workspace->definition->key,
                'title' => $workspace->definition->title,
                'layout' => 'Grid',
            ],
            'widgets' => $this->widgetContainersData($workspace->containers),
        ];
    }

    private function widgetContainersData(array $containers): array
    {
        return array_map(fn (WidgetContainer $container): array => [
            ...$this->widgetDefinitionData($container->definition),
            'status' => $container->status,
            'data' => $container->data,
            'error' => $container->error,
        ], $containers);
    }

    private function widgetDefinitionData(WidgetDefinition $definition): array
    {
        return [
            'key' => $definition->key,
            'workspace' => $definition->workspace,
            'title' => $definition->title,
            'category' => $definition->category,
            'size' => $definition->size,
            'refresh_seconds' => $definition->refreshSeconds,
        ];
    }

    private function defaultWorkspace(array $roleSlugs): string
    {
        return $this->workspaceResolver->resolve($roleSlugs)->key;
    }

    private function perPage(array $filters): int
    {
        return min(max((int) ($filters['per_page'] ?? 15), 1), 100);
    }
}
