<?php

namespace Modules\Notifications\EventBus;

use Modules\Notifications\Contracts\DomainEventInterface;

final class InMemoryEventBus implements EventBusInterface
{
    /** @var array<string, array<int, callable>> */
    private array $subscribers = [];

    public function publish(DomainEventInterface $event): void
    {
        $this->dispatch($event);
    }

    public function subscribe(string $eventName, callable $handler): void
    {
        $this->subscribers[$eventName][] = $handler;
    }

    public function dispatch(DomainEventInterface $event): void
    {
        foreach ($this->subscribers[$event->eventName()] ?? [] as $handler) {
            $handler($event);
        }
    }

    public function retry(DomainEventInterface $event): void
    {
        $this->publish($event);
    }
}
