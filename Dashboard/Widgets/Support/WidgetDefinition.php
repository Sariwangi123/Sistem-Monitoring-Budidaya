<?php

namespace Dashboard\Widgets\Support;

final readonly class WidgetDefinition
{
    public function __construct(
        public string $key,
        public string $workspace,
        public string $title,
        public string $category,
        public string $size = 'Medium',
        public ?int $refreshSeconds = null,
        public ?string $component = null,
        public ?string $requiredPermission = null,
        public ?string $dataSource = null,
        public array $allowedRoles = []
    ) {
    }
}
