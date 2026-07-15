<?php

namespace ReportAnalytics\Engines;

use ReportAnalytics\Builders\ReportBuilder;
use ReportAnalytics\Contracts\ExportEngineInterface;
use ReportAnalytics\Contracts\RenderingEngineInterface;
use ReportAnalytics\Exceptions\ReportGenerationException;
use ReportAnalytics\Exceptions\ReportNotFoundException;
use ReportAnalytics\Exceptions\ReportPermissionException;
use ReportAnalytics\Registry\ReportRegistry;
use ReportAnalytics\Services\ReportCacheService;
use ReportAnalytics\Services\ReportExecutionLogger;
use ReportAnalytics\Services\ReportFileNameService;
use ReportAnalytics\Services\ReportParameterValidator;
use ReportAnalytics\Services\ReportPermissionValidator;
use ReportAnalytics\Services\ReportQueueService;
use ReportAnalytics\Services\ReportTemplateValidator;
use ReportAnalytics\Support\ReportRequest;
use ReportAnalytics\Templates\TemplateEngine;

final class UniversalReportEngine
{
    public function __construct(
        private ReportRegistry $registry,
        private TemplateEngine $templateEngine,
        private ReportBuilder $builder,
        private RenderingEngineInterface $renderer,
        private ExportEngineInterface $exporter,
        private ReportFileNameService $fileNameService,
        private ReportPermissionValidator $permissionValidator,
        private ReportParameterValidator $parameterValidator,
        private ReportTemplateValidator $templateValidator,
        private ReportCacheService $cacheService,
        private ReportQueueService $queueService,
        private ReportExecutionLogger $executionLogger
    ) {
    }

    /** @return array<string, mixed> */
    public function generate(ReportRequest $request): array
    {
        $startedAt = microtime(true);
        $definition = $this->registry->get($request->reportId);

        if ($definition === null) {
            throw ReportNotFoundException::forReport($request->reportId);
        }

        $this->executionLogger->started($definition, $request);

        try {
            $this->permissionValidator->validate($definition, $request->roleSlugs);
            $this->parameterValidator->validate($definition, $request);

            $template = $this->cacheService->rememberMetadata(
                'template',
                ['report_id' => $definition->id, 'template' => $definition->template, 'locale' => $request->locale],
                fn () => $this->templateEngine->resolve($definition)
            );
            $this->templateValidator->validate($definition, $template);

            $build = $this->builder->build($definition, $template, $request->locale, $request->parameters);
            $rendered = $this->renderer->render($build);
            $fileName = $this->fileNameService->make($definition->category, $request->format);
            $export = $this->exporter->export($rendered, $request->format, $fileName);
            $executionTimeMs = round((microtime(true) - $startedAt) * 1000, 2);
            $this->executionLogger->completed($definition, $request, $executionTimeMs, $export['file_size'] ?? null);
        } catch (\Throwable $exception) {
            $this->executionLogger->failed($definition, $request, $exception);

            if ($exception instanceof ReportPermissionException) {
                throw $exception;
            }

            throw ReportGenerationException::failed($definition->id, $exception);
        }

        return [
            'definition' => $definition->toArray(),
            'template' => $template->toArray(),
            'export' => $export,
            'audit' => [
                'user_id' => $request->userId,
                'roles' => $request->roleSlugs,
                'report_type' => $definition->id,
                'export_format' => $request->format,
                'generated_at' => now()->toISOString(),
            ],
            'queue' => $this->queueService->metadata($definition, $request),
            'cache' => [
                'enabled' => true,
                'key' => $this->cacheService->key('request', $this->cacheService->requestContext($definition, $request)),
                'ttl_seconds' => 300,
            ],
            'retry' => [
                'attempts' => 0,
                'max_attempts' => 3,
                'retryable' => true,
            ],
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
                'engine' => 'UniversalReportEngine',
                'workflow' => [
                    'permission_validation',
                    'parameter_validation',
                    'template_validation',
                    'data_collection',
                    'data_aggregation',
                    'report_build',
                    'rendering',
                    'export',
                ],
                'execution_time_ms' => $executionTimeMs,
            ],
        ];
    }
}
