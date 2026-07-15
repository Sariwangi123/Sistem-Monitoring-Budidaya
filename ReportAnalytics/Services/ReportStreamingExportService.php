<?php

namespace ReportAnalytics\Services;

final class ReportStreamingExportService
{
    public function metadata(string $format): array
    {
        return [
            'streaming_export' => true,
            'format' => $format,
            'adapter' => 'streaming_metadata_foundation',
            'production_file_written' => false,
        ];
    }
}
