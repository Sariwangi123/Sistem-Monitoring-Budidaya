<?php

namespace ReportAnalytics\Collectors;

use Dashboard\Services\DashboardService;
use ReportAnalytics\Contracts\DataCollectorInterface;
use ReportAnalytics\Support\ReportDefinition;

final class ServiceLayerDataCollector implements DataCollectorInterface
{
    public function __construct(private DashboardService $dashboardService)
    {
    }

    public function collect(ReportDefinition $definition, array $parameters = []): array
    {
        return [
            'source_module' => $definition->sourceModule,
            'source_strategy' => 'service_layer_only',
            'filters' => $parameters,
            'dashboard_statistics' => $this->dashboardService->statistics()['data'] ?? [],
            'read_only' => true,
        ];
    }
}
