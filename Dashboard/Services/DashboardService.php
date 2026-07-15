<?php

namespace Dashboard\Services;

use Dashboard\Engines\DashboardEngine;
use Dashboard\Exceptions\DashboardCacheException;
use Dashboard\Exceptions\WidgetNotFoundException;
use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Widgets\Support\WidgetDefinition;
use Dashboard\Widgets\WidgetRegistry;
use Dashboard\Workspaces\DashboardWorkspace;
use Dashboard\Workspaces\DashboardWorkspaceResolver;
use Illuminate\Support\Facades\Log;

final class DashboardService
{
    public function __construct(
        private DashboardRepositoryInterface $repository,
        private DashboardEngine $dashboardEngine,
        private WidgetRegistry $widgetRegistry,
        private DashboardWorkspaceResolver $workspaceResolver,
        private DashboardCacheService $cacheService,
        private DashboardOperationalIntelligenceService $intelligenceService
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
                'kpi' => $this->intelligenceService->kpiItems($roleSlugs, $filters),
                'alerts' => $this->intelligenceService->alerts($roleSlugs, $filters),
                'intelligence' => $this->intelligenceService->build($roleSlugs, $filters),
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
        return $this->cachedResponse('kpi', $roleSlugs, $filters, function () use ($roleSlugs, $filters): array {
            $intelligence = $this->intelligenceService->build($roleSlugs, $filters);

            return [
                'workspace' => $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs),
                'items' => $intelligence['kpi_intelligence']['items'],
                'trend' => $intelligence['trend_indicators'],
                'comparison' => $intelligence['comparative_indicators'],
            ];
        });
    }

    public function widgets(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('widgets', $roleSlugs, $filters, function () use ($roleSlugs, $filters): array {
            $workspace = $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs);

            return [
                'workspace' => $workspace,
                'items' => array_values(array_map(
                    fn ($widget): array => $this->widgetDefinitionData($widget->definition()),
                    $this->widgetRegistry->visibleForWorkspace($workspace, $roleSlugs)
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
        $this->clearCacheSafely(fn (string $key, string $scope): bool => $scope === 'widgets' || str_contains($scope, "widget.{$widgetKey}"));

        try {
            return $this->dashboardEngine->refreshWidget($this, $widgetKey, $roleSlugs, $this->perPage($filters));
        } catch (WidgetNotFoundException) {
            return null;
        }
    }

    public function alerts(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse('alerts', $roleSlugs, $filters, fn (): array => [
            'items' => $this->intelligenceService->alerts($roleSlugs, $filters),
            'priority' => ['Critical', 'Warning', 'Information'],
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
        return $this->cachedResponse('analytics', $roleSlugs, $filters, function () use ($roleSlugs, $filters): array {
            $intelligence = $this->intelligenceService->build($roleSlugs, $filters);

            return [
                'workspace' => $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs),
                'summary' => $intelligence['operational_summary'],
                'trend' => $intelligence['trend_indicators'],
                'comparison' => $intelligence['comparative_indicators'],
                'insights' => $intelligence['insight_cards'],
                'recommendations' => $intelligence['recommendations'],
                'health' => [
                    'farm' => $intelligence['farm_health_summary'],
                    'pond' => $intelligence['pond_health_summary'],
                    'financial' => $intelligence['financial_health_summary'],
                    'inventory' => $intelligence['inventory_health_summary'],
                    'production' => $intelligence['production_health_summary'],
                ],
            ];
        });
    }

    public function intelligence(array $roleSlugs, array $filters): array
    {
        return $this->cachedResponse(
            'intelligence',
            $roleSlugs,
            $filters,
            fn (): array => $this->intelligenceService->build($roleSlugs, $filters)
        );
    }

    public function refreshDashboard(array $roleSlugs, array $filters): array
    {
        $workspace = $filters['workspace'] ?? $this->defaultWorkspace($roleSlugs);
        $this->clearCacheSafely();

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
        return [
            'data' => $this->cacheStatusSafely(),
            'message' => 'Dashboard cache status retrieved.',
            'meta' => [
                'cache_status' => 'live',
            ],
        ];
    }

    public function clearCache(): array
    {
        $this->clearCacheSafely();

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
        $cacheStatus = 'miss';
        $cacheTtlSeconds = $this->cacheService->ttlForScope($scope);

        try {
            $cacheResult = $this->cacheService->remember($scope, $roleSlugs, $filters, $callback);
            $data = $cacheResult['data'];
            $cacheStatus = $cacheResult['hit'] ? 'hit' : 'miss';
            $cacheTtlSeconds = $cacheResult['ttl_seconds'];
        } catch (DashboardCacheException $exception) {
            Log::warning('dashboard.cache.failed', [
                'scope' => $scope,
                'message' => $exception->getMessage(),
            ]);

            $data = $callback();
            $cacheStatus = 'bypass';
        }

        $meta = [
            'cache_status' => $cacheStatus,
            'execution_time_ms' => round((microtime(true) - $startedAt) * 1000, 2),
            'cache_ttl_seconds' => $cacheTtlSeconds,
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
            'meta' => $container->meta,
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
            'component' => $definition->component,
            'required_permission' => $definition->requiredPermission,
            'data_source' => $definition->dataSource,
            'allowed_roles' => $definition->allowedRoles,
        ];
    }

    private function cacheStatusSafely(): array
    {
        try {
            return $this->cacheService->status();
        } catch (DashboardCacheException $exception) {
            Log::warning('dashboard.cache.status_failed', ['message' => $exception->getMessage()]);

            return [
                'enabled' => false,
                'ttl_seconds' => $this->cacheService->ttlForScope('default'),
                'tracked_keys' => 0,
            ];
        }
    }

    private function clearCacheSafely(?callable $predicate = null): void
    {
        try {
            $this->cacheService->forget($predicate);
        } catch (DashboardCacheException $exception) {
            Log::warning('dashboard.cache.clear_failed', ['message' => $exception->getMessage()]);
        }
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
