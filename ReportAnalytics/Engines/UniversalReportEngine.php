<?php

namespace ReportAnalytics\Engines;

use ReportAnalytics\Builders\ReportBuilder;
use ReportAnalytics\Contracts\ExportEngineInterface;
use ReportAnalytics\Contracts\RenderingEngineInterface;
use ReportAnalytics\Registry\ReportRegistry;
use ReportAnalytics\Services\ReportFileNameService;
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
        private ReportFileNameService $fileNameService
    ) {
    }

    /** @return array<string, mixed> */
    public function generate(ReportRequest $request): array
    {
        $definition = $this->registry->get($request->reportId);

        if ($definition === null) {
            throw new \InvalidArgumentException('Report definition not found.');
        }

        $template = $this->templateEngine->resolve($definition);
        $build = $this->builder->build($definition, $template, $request->locale, $request->parameters);
        $rendered = $this->renderer->render($build);
        $fileName = $this->fileNameService->make($definition->category, $request->format);

        return [
            'definition' => $definition->toArray(),
            'template' => $template->toArray(),
            'export' => $this->exporter->export($rendered, $request->format, $fileName),
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
                'engine' => 'UniversalReportEngine',
            ],
        ];
    }
}
