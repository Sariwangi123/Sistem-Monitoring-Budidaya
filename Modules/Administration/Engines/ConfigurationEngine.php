<?php

namespace Modules\Administration\Engines;

use Modules\Administration\Services\ConfigurationCache;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Support\ConfigurationRegistry;

final class ConfigurationEngine
{
    public function __construct(private readonly ConfigurationRegistry $registry, private readonly ConfigurationValidator $validator, private readonly ConfigurationCache $cache)
    {
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['single_source_of_truth' => true, 'categories' => $this->cache->registry(fn (): array => $this->registry->categories()), 'cache' => $this->cache->metadata(), 'versioning_enabled' => false, 'rollback_enabled' => false, 'lifecycle' => ['draft', 'validation', 'published', 'active', 'archived']];
    }

    public function validate(string $category, array $payload = []): void
    {
        $this->validator->validate($category, $payload);
    }
}
