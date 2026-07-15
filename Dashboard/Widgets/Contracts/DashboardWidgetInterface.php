<?php

namespace Dashboard\Widgets\Contracts;

use Dashboard\Services\DashboardService;
use Dashboard\Widgets\Support\DashboardWidgetContext;
use Dashboard\Widgets\Support\WidgetDefinition;

interface DashboardWidgetInterface
{
    public function definition(): WidgetDefinition;

    public function load(DashboardService $dashboardService, DashboardWidgetContext $context): array;
}
