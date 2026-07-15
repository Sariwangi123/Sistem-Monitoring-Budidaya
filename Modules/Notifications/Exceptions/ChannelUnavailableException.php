<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;

final class ChannelUnavailableException extends RuntimeException
{
    public static function forChannel(string $channel): self
    {
        return new self("Notification channel '{$channel}' is unavailable.");
    }
}
