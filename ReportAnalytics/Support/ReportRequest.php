<?php

namespace ReportAnalytics\Support;

final readonly class ReportRequest
{
    /** @param array<string, mixed> $parameters */
    public function __construct(
        public string $reportId,
        public string $format = 'json',
        public string $locale = 'id',
        public array $parameters = []
    ) {
    }
}
