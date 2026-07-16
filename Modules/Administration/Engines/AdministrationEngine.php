<?php

namespace Modules\Administration\Engines;

use Modules\Administration\Support\EnvironmentResolver;
use Modules\Administration\Support\ModuleRegistry;
use Modules\Administration\Support\SystemCapabilityRegistry;
use Modules\Administration\Services\ConfigurationCache;

final class AdministrationEngine
{
    public function __construct(private readonly ConfigurationEngine $configuration, private readonly SecurityEngine $security, private readonly MonitoringEngine $monitoring, private readonly AuditEngine $audit, private readonly BackupEngine $backup, private readonly RestoreEngine $restore, private readonly IntegrationEngine $integration, private readonly HealthCheckEngine $health, private readonly ModuleRegistry $modules, private readonly SystemCapabilityRegistry $capabilities, private readonly EnvironmentResolver $environment, private readonly ConfigurationCache $cache)
    {
    }

    /** @return array<string, mixed> */
    public function overview(): array
    {
        $modules = cache()->remember($this->cache->moduleKey(), $this->cache->ttl(), fn (): array => $this->modules->definitions());

        return ['configuration' => $this->configuration->metadata(), 'security' => $this->security->metadata(), 'monitoring' => $this->monitoring->health(), 'audit' => $this->audit->metadata(), 'backup' => $this->backup->metadata(), 'restore' => $this->restore->metadata(), 'integration' => $this->integration->metadata(), 'health' => $this->health->summary(), 'modules' => $modules, 'capabilities' => $this->capabilities->definitions(), 'environment' => $this->environment->resolve(), 'metrics' => ['module_count' => count($modules), 'cache_driver' => config('cache.default'), 'read_only_business_modules' => true, 'business_module_direct_access' => false, 'lifecycle' => 'active', 'performance' => ['module_registry_cache' => true, 'configuration_cache' => true, 'feature_cache' => true, 'user_scoped_cache' => true], 'audit' => ['configuration_changes' => true, 'immutable' => true]]];
    }
}
