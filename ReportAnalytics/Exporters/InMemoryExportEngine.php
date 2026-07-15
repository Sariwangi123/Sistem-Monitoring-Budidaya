<?php

namespace ReportAnalytics\Exporters;

use ReportAnalytics\Contracts\ExportEngineInterface;
use ReportAnalytics\Exceptions\ExportFailedException;
use ReportAnalytics\Services\ReportChunkProcessor;
use ReportAnalytics\Services\ReportStreamingExportService;
use ReportAnalytics\Support\RenderedReport;

final class InMemoryExportEngine implements ExportEngineInterface
{
    private const SUPPORTED_FORMATS = ['pdf', 'xlsx', 'csv', 'json'];

    public function __construct(
        private ?ReportChunkProcessor $chunkProcessor = null,
        private ?ReportStreamingExportService $streamingExportService = null
    ) {
        $this->chunkProcessor ??= new ReportChunkProcessor();
        $this->streamingExportService ??= new ReportStreamingExportService();
    }

    public function export(RenderedReport $report, string $format, string $fileName): array
    {
        if (! in_array($format, self::SUPPORTED_FORMATS, true)) {
            throw ExportFailedException::forFormat($format);
        }

        return [
            'file_name' => $fileName,
            'format' => $format,
            'status' => 'Generated In Memory',
            'production_file_export' => false,
            'adapter' => 'production_ready_metadata_adapter',
            'file_size' => strlen(json_encode($report->payload, JSON_THROW_ON_ERROR)),
            'failure_handling' => [
                'retryable' => true,
                'exception' => ExportFailedException::class,
            ],
            'chunk' => $this->chunkProcessor->metadata($report->payload['build']['sections'] ?? []),
            'streaming' => $this->streamingExportService->metadata($format),
            'payload' => $report->payload,
        ];
    }
}
