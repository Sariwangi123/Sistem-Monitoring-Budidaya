<?php

namespace Modules\Notifications\Exceptions;

use RuntimeException;

final class InvalidRecipientException extends RuntimeException
{
    public static function forStrategy(string $strategy): self
    {
        return new self("Notification recipient strategy '{$strategy}' did not resolve recipients.");
    }
}
