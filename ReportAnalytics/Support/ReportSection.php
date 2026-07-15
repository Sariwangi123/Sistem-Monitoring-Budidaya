<?php

namespace ReportAnalytics\Support;

final readonly class ReportSection
{
    /** @param array<string, mixed> $data */
    public function __construct(
        public string $key,
        public string $title,
        public array $data
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'title' => $this->title,
            'data' => $this->data,
        ];
    }
}
