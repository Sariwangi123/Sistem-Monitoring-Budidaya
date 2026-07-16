<?php

namespace Modules\Administration\Exceptions;

final class ConfigurationNotFoundException extends AdministrationException
{
    public static function forCategory(string $category): self
    {
        return new self("Configuration category [{$category}] is not registered.");
    }
}
