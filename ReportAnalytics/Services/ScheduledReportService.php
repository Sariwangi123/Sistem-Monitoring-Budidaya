<?php

namespace ReportAnalytics\Services;

use ReportAnalytics\Exceptions\ReportPermissionException;
use ReportAnalytics\Registry\ReportRegistry;
use ReportAnalytics\Support\ReportDefinition;

final class ScheduledReportService
{
    private const FREQUENCIES = ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'];

    public function __construct(
        private ReportRegistry $registry,
        private ReportPermissionValidator $permissionValidator
    ) {
    }

    /** @return array<string, mixed> */
    public function foundation(array $filters = []): array
    {
        return [
            'items' => [],
            'foundation' => [
                'supported_frequencies' => self::FREQUENCIES,
                'status_values' => ['active', 'inactive', 'paused'],
                'queue_status_values' => ['pending', 'processing', 'completed', 'failed'],
                'production_scheduler' => false,
                'production_delivery' => false,
                'notification_module_dependency' => false,
                'filters' => $filters,
            ],
        ];
    }

    /** @param array<int, string> $roleSlugs */
    public function create(array $payload, array $roleSlugs): array
    {
        $definition = $this->definition($payload['report_id']);
        $this->permissionValidator->validate($definition, $roleSlugs);

        if (! in_array($payload['frequency'], self::FREQUENCIES, true)) {
            throw new \InvalidArgumentException('Scheduled report frequency is not supported.');
        }

        if (! in_array($payload['export_format'], $definition->supportedExportFormats, true)) {
            throw new \InvalidArgumentException('Scheduled report export format is not supported.');
        }

        return [
            'uuid' => (string) str()->uuid(),
            'report' => $definition->toArray(),
            'frequency' => $payload['frequency'],
            'export_format' => $payload['export_format'],
            'timezone' => $payload['timezone'] ?? config('app.timezone'),
            'filters' => $payload['filters'] ?? [],
            'status' => 'Accepted',
            'lifecycle_status' => 'active',
            'queue_status' => 'pending',
            'retry' => [
                'attempts' => 0,
                'max_attempts' => 3,
                'retryable' => true,
            ],
            'production_scheduler' => false,
            'production_delivery' => false,
        ];
    }

    /** @return array<string, mixed> */
    public function deactivate(string $uuid): array
    {
        return [
            'uuid' => $uuid,
            'deleted' => true,
            'status' => 'inactive',
            'production_scheduler' => false,
            'production_delivery' => false,
        ];
    }

    private function definition(string $reportId): ReportDefinition
    {
        $definition = $this->registry->get($reportId);

        if (! $definition) {
            throw new ReportPermissionException('Scheduled report definition is not accessible.');
        }

        return $definition;
    }
}
