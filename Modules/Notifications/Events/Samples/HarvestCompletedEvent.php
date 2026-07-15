<?php

namespace Modules\Notifications\Events\Samples;

use DateTimeImmutable;
use Modules\Notifications\Contracts\DomainEventInterface;
use Modules\Notifications\Events\ImmutableDomainEvent;

final readonly class HarvestCompletedEvent implements DomainEventInterface
{
    private ImmutableDomainEvent $event;

    /** @param array<string, mixed> $payload */
    public function __construct(array $payload = [], ?DateTimeImmutable $occurredAt = null, ?string $correlationId = null)
    {
        $this->event = new ImmutableDomainEvent(
            'harvest.completed',
            'Harvest',
            $payload,
            $occurredAt,
            $correlationId
        );
    }

    public function eventName(): string
    {
        return $this->event->eventName();
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->event->occurredAt();
    }

    public function payload(): array
    {
        return $this->event->payload();
    }

    public function sourceModule(): string
    {
        return $this->event->sourceModule();
    }

    public function correlationId(): string
    {
        return $this->event->correlationId();
    }
}
