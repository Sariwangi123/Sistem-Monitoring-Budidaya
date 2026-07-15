<?php

namespace ReportAnalytics\Support;

final readonly class ReportTemplate
{
    /**
     * @param array<int, string> $sections
     * @param array<string, mixed> $format
     */
    public function __construct(
        public string $key,
        public string $title,
        public ReportLayout $layout,
        public array $sections,
        public array $format = []
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'title' => $this->title,
            'layout' => $this->layout->toArray(),
            'sections' => $this->sections,
            'format' => $this->format,
        ];
    }
}
