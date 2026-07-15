<?php

namespace Dashboard\Widgets;

use Dashboard\Widgets\Contracts\DashboardWidgetInterface;
use InvalidArgumentException;

final class WidgetRegistry
{
    /** @var array<string, DashboardWidgetInterface> */
    private array $widgets = [];

    public function register(DashboardWidgetInterface $widget): void
    {
        $key = $widget->definition()->key;

        if (isset($this->widgets[$key])) {
            throw new InvalidArgumentException("Dashboard widget '{$key}' is already registered.");
        }

        $this->widgets[$key] = $widget;
    }

    /** @return array<string, DashboardWidgetInterface> */
    public function all(): array
    {
        return $this->widgets;
    }

    public function find(string $key): ?DashboardWidgetInterface
    {
        return $this->widgets[$key] ?? null;
    }

    /** @return array<string, DashboardWidgetInterface> */
    public function forWorkspace(string $workspace): array
    {
        return array_filter(
            $this->widgets,
            fn (DashboardWidgetInterface $widget): bool => $widget->definition()->workspace === $workspace
        );
    }
}
