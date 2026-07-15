<?php

namespace Dashboard\Engines;

use Dashboard\Exceptions\WidgetPermissionException;
use Dashboard\Services\DashboardService;
use Dashboard\Widgets\Support\DashboardWidgetContext;
use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Widgets\WidgetRegistry;
use Illuminate\Support\Facades\Log;
use Throwable;

final class WidgetEngine
{
    public function __construct(private WidgetRegistry $registry)
    {
    }

    public function load(string $workspace, array $roleSlugs, int $perPage, DashboardService $dashboardService): array
    {
        $context = new DashboardWidgetContext($workspace, $roleSlugs, $perPage);
        $containers = [];

        foreach ($this->registry->visibleForWorkspace($workspace, $roleSlugs) as $widget) {
            $startedAt = microtime(true);

            try {
                $containers[] = new WidgetContainer(
                    $widget->definition(),
                    'Loaded',
                    $widget->load($dashboardService, $context),
                    null,
                    $this->meta($startedAt, 'loaded')
                );
            } catch (Throwable $exception) {
                Log::warning('dashboard.widget.failed', [
                    'widget' => $widget->definition()->key,
                    'workspace' => $workspace,
                    'message' => $exception->getMessage(),
                ]);

                $containers[] = new WidgetContainer(
                    $widget->definition(),
                    'Error',
                    [],
                    'Widget data could not be loaded.',
                    $this->meta($startedAt, 'error')
                );
            }
        }

        return $containers;
    }

    public function refresh(string $widgetKey, array $roleSlugs, int $perPage, DashboardService $dashboardService): ?WidgetContainer
    {
        $widget = $this->registry->get($widgetKey);

        if (! $this->registry->isVisibleForRoles($widget, $roleSlugs)) {
            throw WidgetPermissionException::forWidget($widgetKey);
        }

        $startedAt = microtime(true);
        $context = new DashboardWidgetContext($widget->definition()->workspace, $roleSlugs, $perPage, true);

        try {
            return new WidgetContainer(
                $widget->definition(),
                'Loaded',
                $widget->load($dashboardService, $context),
                null,
                $this->meta($startedAt, 'refreshed')
            );
        } catch (Throwable $exception) {
            Log::warning('dashboard.widget.refresh_failed', [
                'widget' => $widget->definition()->key,
                'workspace' => $widget->definition()->workspace,
                'message' => $exception->getMessage(),
            ]);

            return new WidgetContainer(
                $widget->definition(),
                'Error',
                [],
                'Widget data could not be loaded.',
                $this->meta($startedAt, 'error')
            );
        }
    }

    private function meta(float $startedAt, string $lifecycle): array
    {
        return [
            'lifecycle' => $lifecycle,
            'execution_time_ms' => round((microtime(true) - $startedAt) * 1000, 2),
        ];
    }
}
