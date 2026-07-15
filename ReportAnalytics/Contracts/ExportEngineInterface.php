<?php

namespace ReportAnalytics\Contracts;

use ReportAnalytics\Support\RenderedReport;

interface ExportEngineInterface
{
    /** @return array<string, mixed> */
    public function export(RenderedReport $report, string $format, string $fileName): array;
}
