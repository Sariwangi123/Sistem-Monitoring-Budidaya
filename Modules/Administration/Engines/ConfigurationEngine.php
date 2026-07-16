<?php

namespace Modules\Administration\Engines;

use Modules\Administration\Services\ConfigurationCache;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Support\ConfigurationRegistry;
use Illuminate\Support\Facades\Cache;
use Infrastructure\Logging\AuditLogger;

final class ConfigurationEngine
{
    public function __construct(private readonly ConfigurationRegistry $registry, private readonly ConfigurationValidator $validator, private readonly ConfigurationCache $cache, private readonly AuditLogger $audit)
    {
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['single_source_of_truth' => true, 'categories' => $this->cache->registry(fn (): array => $this->registry->categories()), 'cache' => $this->cache->metadata(), 'versioning_enabled' => false, 'rollback_enabled' => false, 'synchronization' => 'cache_invalidation_on_update', 'lifecycle' => ['draft', 'validation', 'published', 'active', 'deprecated', 'archived']];
    }

    public function validate(string $category, array $payload = []): void
    {
        $this->validator->validate($category, $payload);
    }

    /** @return array<string, mixed> */
    public function configuration(string $category): array
    {
        $this->validate($category);

        return Cache::get($this->key($category), ['key' => $category, 'enabled' => true, 'values' => [], 'source' => 'configuration_registry']);
    }

    /** @return array<string, mixed> */
    public function update(string $category, array $payload): array
    {
        $this->validate($category, $payload);
        $configuration = [...$this->configuration($category), ...array_filter($payload, fn ($value): bool => $value !== null)];
        Cache::put($this->key($category), $configuration, $this->cache->ttl());
        $this->cache->forgetRegistry();
        $this->audit->record('administration.configuration.updated', ['category' => $category]);

        return $configuration;
    }

    private function key(string $category): string
    {
        return "administration:configuration:{$category}";
    }
}
