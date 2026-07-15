<?php

namespace Dashboard\Exceptions;

use RuntimeException;
use Throwable;

final class DashboardCacheException extends RuntimeException
{
    public static function operationFailed(string $operation, Throwable $previous): self
    {
        return new self("Dashboard cache operation '{$operation}' failed.", previous: $previous);
    }
}
