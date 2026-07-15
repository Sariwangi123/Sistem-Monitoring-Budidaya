<?php

namespace ReportAnalytics\Exporters;

use ReportAnalytics\Contracts\ExportEngineInterface;
use ReportAnalytics\Support\RenderedReport;

final class InMemoryExportEngine implements ExportEngineInterface
{
    public function export(RenderedReport $report, string $format, string $fileName): array
    {
        return [
            'file_name' => $fileName,
            'format' => $format,
            'status' => 'Generated In Memory',
            'production_file_export' => false,
            'payload' => $report->payload,
        ];
    }
}
