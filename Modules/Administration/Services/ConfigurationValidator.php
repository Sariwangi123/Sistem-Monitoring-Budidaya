<?php

namespace Modules\Administration\Services;

use Modules\Administration\Exceptions\ConfigurationNotFoundException;
use Modules\Administration\Exceptions\InvalidConfigurationException;
use Modules\Administration\Support\ConfigurationRegistry;

final class ConfigurationValidator
{
    public function __construct(private readonly ConfigurationRegistry $registry)
    {
    }

    public function validate(string $category, array $payload = []): void
    {
        if (! $this->registry->hasCategory($category)) {
            throw ConfigurationNotFoundException::forCategory($category);
        }

        if (array_key_exists('enabled', $payload) && ! is_bool($payload['enabled'])) {
            throw InvalidConfigurationException::forCategory($category);
        }
    }
}
