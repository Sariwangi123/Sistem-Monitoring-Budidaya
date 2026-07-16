<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;
use Throwable;

final class NotificationQueueException extends RuntimeException
{
    public static function dispatchFailed(string $eventName, Throwable $previous): self
    {
        return new self("Notification queue dispatch failed for event '{$eventName}'.", previous: $previous);
    }
}
