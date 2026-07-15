<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;
use Throwable;

final class DeliveryFailedException extends RuntimeException
{
    public static function forChannel(string $channel, ?Throwable $previous = null): self
    {
        return new self("Notification delivery failed for channel '{$channel}'.", previous: $previous);
    }
}
