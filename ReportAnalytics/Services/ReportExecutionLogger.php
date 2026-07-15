<?php

namespace ReportAnalytics\Services;

use Illuminate\Support\Facades\Log;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;

final class ReportExecutionLogger
{
    public function started(ReportDefinition $definition, ReportRequest $request): void
    {
        Log::info('report_analytics.engine.started', $this->baseContext($definition, $request));
    }

    public function completed(ReportDefinition $definition, ReportRequest $request, float $executionTimeMs, ?int $fileSize = null): void
    {
        Log::info('report_analytics.engine.completed', $this->baseContext($definition, $request) + [
            'execution_time_ms' => $executionTimeMs,
            'file_size' => $fileSize,
            'generated_at' => now()->toISOString(),
        ]);
    }

    public function failed(ReportDefinition $definition, ReportRequest $request, \Throwable $exception): void
    {
        Log::error('report_analytics.engine.failed', $this->baseContext($definition, $request) + [
            'exception' => $exception::class,
            'message' => $exception->getMessage(),
            'retryable' => true,
        ]);
    }

    /** @return array<string, mixed> */
    private function baseContext(ReportDefinition $definition, ReportRequest $request): array
    {
        return [
            'user_id' => $request->userId,
            'roles' => $request->roleSlugs,
            'report_type' => $definition->id,
            'report_category' => $definition->category,
            'export_format' => $request->format,
            'queue_id' => null,
        ];
    }
}
