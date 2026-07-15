<?php

namespace ReportAnalytics\Support;

final readonly class ReportLayout
{
    public function __construct(
        public string $cover,
        public string $header,
        public string $body,
        public string $summary,
        public string $footer
    ) {
    }

    /** @return array<string, string> */
    public function toArray(): array
    {
        return [
            'cover' => $this->cover,
            'header' => $this->header,
            'body' => $this->body,
            'summary' => $this->summary,
            'footer' => $this->footer,
        ];
    }
}
