<?php

namespace Modules\Administration\Exceptions;

use RuntimeException;

final class ConfigurationNotFoundException extends RuntimeException
{
    public static function forCategory(string $category): self
    {
        return new self("Configuration category [{$category}] is not registered.");
    }
}
