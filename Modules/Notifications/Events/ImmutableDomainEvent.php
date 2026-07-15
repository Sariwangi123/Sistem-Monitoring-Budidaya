<?php

namespace Modules\Notifications\Events;

use DateTimeImmutable;
use Illuminate\Support\Str;
use Modules\Notifications\Contracts\DomainEventInterface;

final readonly class ImmutableDomainEvent implements DomainEventInterface
{
    private DateTimeImmutable $resolvedOccurredAt;

    private string $resolvedCorrelationId;

    /** @param array<string, mixed> $payload */
    public function __construct(
        private string $name,
        private string $sourceModule,
        private array $payload = [],
        private ?DateTimeImmutable $occurredAt = null,
        private ?string $correlationId = null
    ) {
        $this->resolvedOccurredAt = $this->occurredAt ?? new DateTimeImmutable();
        $this->resolvedCorrelationId = $this->correlationId ?? (string) Str::uuid();
    }

    public function eventName(): string
    {
        return $this->name;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->resolvedOccurredAt;
    }

    /** @return array<string, mixed> */
    public function payload(): array
    {
        return $this->payload;
    }

    public function sourceModule(): string
    {
        return $this->sourceModule;
    }

    public function correlationId(): string
    {
        return $this->resolvedCorrelationId;
    }
}
