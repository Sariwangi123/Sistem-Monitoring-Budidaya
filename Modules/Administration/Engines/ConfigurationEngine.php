<?php

namespace Modules\Administration\Engines;

use Modules\Administration\Services\ConfigurationCache;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Support\ConfigurationRegistry;
use Illuminate\Support\Arr;
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
        return ['single_source_of_truth' => true, 'categories' => $this->cache->registry(fn (): array => $this->registry->categories()), 'cache' => $this->cache->metadata(), 'versioning_enabled' => true, 'rollback_enabled' => 'metadata_only', 'synchronization' => 'cache_refresh_on_publish', 'lifecycle' => ['draft', 'validation', 'approval_optional', 'published', 'active', 'deprecated', 'archived']];
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
        $old = $this->configuration($category);
        $version = count($this->history($category)) + 1;
        $configurationPayload = array_filter(Arr::except($payload, ['reason', 'change_summary']), fn ($value): bool => $value !== null);
        $configuration = [...$old, ...$configurationPayload, 'version' => $version, 'status' => 'active', 'published_at' => now()->toISOString(), 'published_by' => auth()->id()];
        Cache::put($this->key($category), $configuration, $this->cache->ttl());
        $this->recordHistory($category, $old, $configuration, $payload);
        $this->cache->forgetRegistry();
        $this->audit->record('administration.configuration.updated', ['category' => $category]);

        return $configuration;
    }

    /** @return array<int, array<string, mixed>> */
    public function versions(string $category): array
    {
        $this->validate($category);

        return array_map(fn (array $history): array => [
            'version' => $history['version'],
            'status' => $history['status'],
            'created_by' => $history['changed_by'],
            'published_by' => $history['published_by'],
            'published_at' => $history['timestamp'],
            'change_summary' => $history['change_summary'],
            'rollback_point' => $history['rollback_point'],
        ], $this->history($category));
    }

    /** @return array<int, array<string, mixed>> */
    public function history(string $category): array
    {
        $this->validate($category);

        return Cache::get($this->historyKey($category), []);
    }

    /** @return array<string, mixed> */
    public function publishMetadata(string $category): array
    {
        $this->validate($category);

        return [
            'category' => $category,
            'workflow' => ['draft', 'validation', 'approval_optional', 'published', 'audit', 'notification', 'cache_refresh', 'active'],
            'status' => 'ready',
            'notification_event_integration' => 'metadata_only_existing_notification_engine',
            'cache_refresh_required' => true,
        ];
    }

    /** @return array<string, mixed> */
    public function rollbackMetadata(string $category): array
    {
        $this->validate($category);

        return [
            'category' => $category,
            'available' => true,
            'mode' => 'metadata_only',
            'restore_requires_part_7_or_manual_approval' => true,
            'rollback_points' => array_map(fn (array $item): array => $item['rollback_point'], $this->history($category)),
        ];
    }

    /** @return array<string, mixed> */
    public function refreshCache(string $category): array
    {
        $this->validate($category);
        $this->cache->forgetConfiguration($category);
        $this->cache->forgetRegistry();

        return ['category' => $category, 'refreshed' => true, 'driver' => config('cache.default')];
    }

    /** @param array<string, mixed> $old @param array<string, mixed> $new @param array<string, mixed> $payload */
    private function recordHistory(string $category, array $old, array $new, array $payload): void
    {
        $history = $this->history($category);
        $version = $new['version'] ?? count($history) + 1;
        $history[] = [
            'configuration_key' => $category,
            'category' => $category,
            'old_value' => $this->maskSensitive($old),
            'new_value' => $this->maskSensitive($new),
            'version' => $version,
            'status' => 'published',
            'changed_by' => auth()->id(),
            'published_by' => auth()->id(),
            'timestamp' => now()->toISOString(),
            'change_summary' => $payload['change_summary'] ?? 'Configuration updated through Administration API.',
            'reason' => $payload['reason'] ?? 'Administrative configuration governance update.',
            'rollback_point' => ['version' => $version, 'available' => true, 'metadata_only' => true],
            'immutable' => true,
        ];

        Cache::put($this->historyKey($category), $history, $this->cache->ttl());
    }

    /** @param array<string, mixed> $value @return array<string, mixed> */
    private function maskSensitive(array $value): array
    {
        array_walk_recursive($value, function (mixed &$item, string|int $key): void {
            if (str_contains((string) $key, 'password') || str_contains((string) $key, 'secret') || str_contains((string) $key, 'token')) {
                $item = '********';
            }
        });

        return $value;
    }

    private function key(string $category): string
    {
        return "administration:configuration:{$category}";
    }

    private function historyKey(string $category): string
    {
        return "administration:configuration-history:{$category}";
    }
}
