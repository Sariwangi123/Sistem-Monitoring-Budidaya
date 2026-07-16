<?php

namespace Modules\Administration\Services;

use Illuminate\Support\Facades\Cache;
use Modules\Administration\Exceptions\ConfigurationNotFoundException;
use Modules\Administration\Support\ModuleRegistry;

final class FeatureToggleService
{
    public function __construct(private readonly ModuleRegistry $modules)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function all(): array
    {
        return array_map(fn (array $module): array => [...$module, 'state' => Cache::get($this->key($module['key']), $module['toggle'])], $this->modules->definitions());
    }

    /** @return array<string, mixed> */
    public function update(string $feature, string $state): array
    {
        $definition = collect($this->modules->definitions())->firstWhere('key', $feature);

        if ($definition === null) {
            throw ConfigurationNotFoundException::forCategory($feature);
        }

        Cache::forever($this->key($feature), $state);

        return [...$definition, 'state' => $state];
    }

    private function key(string $feature): string
    {
        return "administration:feature-toggle:{$feature}";
    }
}
