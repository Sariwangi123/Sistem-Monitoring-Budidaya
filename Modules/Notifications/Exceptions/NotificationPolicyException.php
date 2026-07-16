<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;

final class NotificationPolicyException extends RuntimeException
{
    public static function forEvent(string $eventName, string $reason): self
    {
        return new self("Notification policy for event '{$eventName}' is invalid: {$reason}.");
    }
}
