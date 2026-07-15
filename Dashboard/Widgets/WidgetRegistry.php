<?php

namespace Dashboard\Widgets;

use Dashboard\Exceptions\WidgetNotFoundException;
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

    public function get(string $key): DashboardWidgetInterface
    {
        return $this->widgets[$key] ?? throw WidgetNotFoundException::forKey($key);
    }

    /** @return array<string, DashboardWidgetInterface> */
    public function forWorkspace(string $workspace): array
    {
        return array_filter(
            $this->widgets,
            fn (DashboardWidgetInterface $widget): bool => $widget->definition()->workspace === $workspace
        );
    }

    /** @return array<string, DashboardWidgetInterface> */
    public function visibleForWorkspace(string $workspace, array $roleSlugs): array
    {
        return array_filter(
            $this->forWorkspace($workspace),
            fn (DashboardWidgetInterface $widget): bool => $this->isVisibleForRoles($widget, $roleSlugs)
        );
    }

    public function isVisibleForRoles(DashboardWidgetInterface $widget, array $roleSlugs): bool
    {
        $allowedRoles = $widget->definition()->allowedRoles;

        return $allowedRoles === [] || array_intersect($allowedRoles, $roleSlugs) !== [];
    }
}
