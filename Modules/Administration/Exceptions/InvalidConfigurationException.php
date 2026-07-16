<?php

namespace Modules\Administration\Exceptions;

use RuntimeException;

final class InvalidConfigurationException extends RuntimeException
{
    public static function forCategory(string $category): self
    {
        return new self("Configuration payload for [{$category}] is invalid.");
    }
}
