<?php

namespace ReportAnalytics\Support;

final readonly class ReportBuild
{
    /** @param array<int, ReportSection> $sections */
    public function __construct(
        public ReportDefinition $definition,
        public ReportTemplate $template,
        public array $sections,
        public string $locale
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'definition' => $this->definition->toArray(),
            'template' => $this->template->toArray(),
            'sections' => array_map(fn (ReportSection $section): array => $section->toArray(), $this->sections),
            'locale' => $this->locale,
        ];
    }
}
