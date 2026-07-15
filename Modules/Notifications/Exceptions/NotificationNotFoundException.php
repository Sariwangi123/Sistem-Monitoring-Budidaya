<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;

final class NotificationNotFoundException extends RuntimeException
{
    public static function forNotification(string $identifier): self
    {
        return new self("Notification '{$identifier}' was not found.");
    }
}
