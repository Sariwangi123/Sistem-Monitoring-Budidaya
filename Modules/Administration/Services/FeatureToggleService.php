<?php

namespace Modules\Administration\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Administration\Exceptions\ConfigurationNotFoundException;
use Modules\Administration\Support\ModuleRegistry;

final class FeatureToggleService
{
    public function __construct(private readonly ModuleRegistry $modules, private readonly ConfigurationCache $cache)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        return array_map(fn (array $module): array => [...$module, 'state' => Cache::get($this->key($module['key']), $module['toggle']), 'cache_scope' => 'feature'], $this->modules->definitions());
    }

    /** @return array<string, mixed> */
    public function update(string $feature, string $state): array
    {
        $definition = collect($this->modules->definitions())->firstWhere('key', $feature);

        if ($definition === null) {
            throw ConfigurationNotFoundException::forCategory($feature);
        }

        Cache::put($this->key($feature), $state, $this->cache->ttl());

        return [...$definition, 'state' => $state, 'cache_scope' => 'feature'];
    }

    public function enabled(string $feature): bool
    {
        $definition = collect($this->modules->definitions())->firstWhere('key', $feature);

        return Cache::get($this->key($feature), $definition['toggle'] ?? 'disabled') === 'enabled';
    }

    private function key(string $feature): string
    {
        return $this->cache->featureKey($feature);
    }
}
