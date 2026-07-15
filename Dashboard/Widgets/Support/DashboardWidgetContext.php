<?php

namespace Dashboard\Widgets\Support;

final readonly class DashboardWidgetContext
{
    public function __construct(
        public string $workspace,
        public array $roleSlugs,
        public int $perPage
    ) {
    }
}
