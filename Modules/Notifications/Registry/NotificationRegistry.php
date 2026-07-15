<?php

namespace Modules\Notifications\Registry;

use InvalidArgumentException;
use Modules\Notifications\Exceptions\EventNotRegisteredException;
use Modules\Notifications\Support\NotificationDefinition;
use Modules\Notifications\Support\RetryPolicy;

final class NotificationRegistry
{
    /** @var array<string, NotificationDefinition> */
    private array $definitions = [];

    public function __construct()
    {
        foreach ($this->defaultDefinitions() as $definition) {
            $this->register($definition);
        }
    }

    public function register(NotificationDefinition $definition): void
    {
        if (isset($this->definitions[$definition->eventName])) {
            throw new InvalidArgumentException("Notification event '{$definition->eventName}' is already registered.");
        }

        $this->definitions[$definition->eventName] = $definition;
    }

    public function find(string $eventName): ?NotificationDefinition
    {
        return $this->definitions[$eventName] ?? null;
    }

    public function get(string $eventName): NotificationDefinition
    {
        return $this->find($eventName) ?? throw EventNotRegisteredException::forEvent($eventName);
    }

    /** @return array<int, NotificationDefinition> */
    public function all(): array
    {
        return array_values($this->definitions);
    }

    /** @return array<int, NotificationDefinition> */
    private function defaultDefinitions(): array
    {
        return [
            new NotificationDefinition(
                'harvest.completed',
                'harvest_completion_alert',
                'harvest',
                'high',
                ['in_app'],
                'role:farm-manager',
                'harvest-completed',
                new RetryPolicy(),
                '1.0',
                'Harvest Completed',
                'Harvest activity has been completed and is ready for review.',
                ['super-admin', 'farm-owner', 'director', 'farm-manager']
            ),
            new NotificationDefinition(
                'inventory.low_stock_detected',
                'low_stock_alert',
                'inventory',
                'critical',
                ['in_app'],
                'role:warehouse-staff',
                'low-stock-detected',
                new RetryPolicy(),
                '1.0',
                'Low Stock Detected',
                'Inventory stock is below configured safety level.',
                ['super-admin', 'farm-manager', 'warehouse-staff']
            ),
        ];
    }
}
