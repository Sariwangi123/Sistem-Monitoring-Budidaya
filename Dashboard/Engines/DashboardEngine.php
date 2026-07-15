<?php

namespace Dashboard\Engines;

use Dashboard\Services\DashboardService;
use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Workspaces\DashboardWorkspace;
use Dashboard\Workspaces\DashboardWorkspaceResolver;

final class DashboardEngine
{
    public function __construct(
        private DashboardWorkspaceResolver $workspaceResolver,
        private WidgetEngine $widgetEngine
    ) {
    }

    public function buildWorkspace(
        DashboardService $dashboardService,
        array $roleSlugs,
        ?string $requestedWorkspace,
        int $perPage
    ): DashboardWorkspace {
        $workspace = $this->workspaceResolver->resolve($roleSlugs, $requestedWorkspace);

        return new DashboardWorkspace(
            $workspace,
            $this->widgetEngine->load($workspace->key, $roleSlugs, $perPage, $dashboardService)
        );
    }

    public function refreshWidget(
        DashboardService $dashboardService,
        string $widgetKey,
        array $roleSlugs,
        int $perPage
    ): ?WidgetContainer {
        return $this->widgetEngine->refresh($widgetKey, $roleSlugs, $perPage, $dashboardService);
    }
}
