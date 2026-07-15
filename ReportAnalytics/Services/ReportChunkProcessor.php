<?php

namespace ReportAnalytics\Services;

final class ReportChunkProcessor
{
    /** @param array<int, mixed> $items */
    public function metadata(array $items, int $chunkSize = 500): array
    {
        return [
            'chunk_processing' => true,
            'chunk_size' => $chunkSize,
            'total_items' => count($items),
            'chunks' => (int) ceil(max(count($items), 1) / $chunkSize),
        ];
    }
}
