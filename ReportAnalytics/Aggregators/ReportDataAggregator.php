<?php

namespace ReportAnalytics\Aggregators;

use ReportAnalytics\Support\ReportDefinition;

final class ReportDataAggregator
{
    /** @param array<string, mixed> $collectedData */
    public function aggregate(ReportDefinition $definition, array $collectedData): array
    {
        return [
            'report_id' => $definition->id,
            'category' => $definition->category,
            'source_module' => $definition->sourceModule,
            'summary' => [
                'status' => 'Aggregated',
                'read_only' => true,
                'source_strategy' => $collectedData['source_strategy'] ?? 'service_layer_only',
            ],
            'read_only' => true,
            'groups' => [
                'filters' => $collectedData['filters'] ?? [],
                'dashboard_statistics' => $collectedData['dashboard_statistics'] ?? [],
            ],
            'raw' => $collectedData,
        ];
    }
}
