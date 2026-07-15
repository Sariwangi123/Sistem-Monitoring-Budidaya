<?php

namespace ReportAnalytics\Support;

final readonly class RenderedReport
{
    /** @param array<string, mixed> $payload */
    public function __construct(
        public ReportDefinition $definition,
        public ReportTemplate $template,
        public array $payload
    ) {
    }
}
