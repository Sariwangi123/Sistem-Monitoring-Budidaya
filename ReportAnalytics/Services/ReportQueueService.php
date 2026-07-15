<?php

namespace ReportAnalytics\Services;

use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;

final class ReportQueueService
{
    public function shouldQueue(ReportDefinition $definition, ReportRequest $request): bool
    {
        return (bool) ($request->parameters['parameter']['queue'] ?? false)
            || ($request->parameters['parameter']['size'] ?? null) === 'large';
    }

    /** @return array<string, mixed> */
    public function metadata(ReportDefinition $definition, ReportRequest $request): array
    {
        return [
            'queue_enabled' => true,
            'queued' => $this->shouldQueue($definition, $request),
            'status' => $this->shouldQueue($definition, $request) ? 'pending' : 'completed',
            'progress' => $this->shouldQueue($definition, $request) ? 0 : 100,
            'retry' => [
                'attempts' => 0,
                'max_attempts' => 3,
                'retryable' => true,
            ],
            'background_job' => [
                'class' => \ReportAnalytics\Jobs\GenerateReportJob::class,
                'production_delivery' => false,
            ],
        ];
    }
}
