<?php

namespace Modules\Notifications\Contracts;

use DateTimeImmutable;

interface DomainEventInterface
{
    public function eventName(): string;

    public function occurredAt(): DateTimeImmutable;

    /** @return array<string, mixed> */
    public function payload(): array;

    public function sourceModule(): string;

    public function correlationId(): string;
}
