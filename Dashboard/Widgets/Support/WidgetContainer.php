<?php

namespace Dashboard\Widgets\Support;

final readonly class WidgetContainer
{
    public function __construct(
        public WidgetDefinition $definition,
        public string $status,
        public array $data = [],
        public ?string $error = null,
        public array $meta = []
    ) {
    }
}
