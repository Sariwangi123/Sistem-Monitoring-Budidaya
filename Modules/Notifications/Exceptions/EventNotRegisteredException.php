<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;

final class EventNotRegisteredException extends RuntimeException
{
    public static function forEvent(string $eventName): self
    {
        return new self("Notification event '{$eventName}' is not registered.");
    }
}
