<?php

namespace Modules\Notifications\EventBus;

use Modules\Notifications\Contracts\DomainEventInterface;

interface EventBusInterface
{
    public function publish(DomainEventInterface $event): void;

    public function subscribe(string $eventName, callable $handler): void;

    public function dispatch(DomainEventInterface $event): void;

    public function retry(DomainEventInterface $event): void;
}
