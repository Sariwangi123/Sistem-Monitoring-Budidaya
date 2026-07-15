<?php

namespace Dashboard\Engines;

use Dashboard\Services\DashboardService;
use Dashboard\Widgets\Support\DashboardWidgetContext;
use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Widgets\WidgetRegistry;
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

        foreach ($this->registry->forWorkspace($workspace) as $widget) {
            try {
                $containers[] = new WidgetContainer(
                    $widget->definition(),
                    'Loaded',
                    $widget->load($dashboardService, $context)
                );
            } catch (Throwable) {
                $containers[] = new WidgetContainer(
                    $widget->definition(),
                    'Error',
                    [],
                    'Widget data could not be loaded.'
                );
            }
        }

        return $containers;
    }

    public function refresh(string $widgetKey, array $roleSlugs, int $perPage, DashboardService $dashboardService): ?WidgetContainer
    {
        $widget = $this->registry->find($widgetKey);

        if (! $widget) {
            return null;
        }

        $context = new DashboardWidgetContext($widget->definition()->workspace, $roleSlugs, $perPage);

        try {
            return new WidgetContainer(
                $widget->definition(),
                'Loaded',
                $widget->load($dashboardService, $context)
            );
        } catch (Throwable) {
            return new WidgetContainer(
                $widget->definition(),
                'Error',
                [],
                'Widget data could not be loaded.'
            );
        }
    }
}
