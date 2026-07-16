<?php

namespace Modules\Administration\Exceptions;

final class InvalidConfigurationException extends AdministrationException
{
    public static function forCategory(string $category): self
    {
        return new self("Configuration payload for [{$category}] is invalid.");
    }
}
