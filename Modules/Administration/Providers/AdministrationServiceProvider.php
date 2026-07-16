<?php

namespace Modules\Administration\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Engines\AuditEngine;
use Modules\Administration\Engines\BackupEngine;
use Modules\Administration\Engines\ConfigurationEngine;
use Modules\Administration\Engines\HealthCheckEngine;
use Modules\Administration\Engines\IntegrationEngine;
use Modules\Administration\Engines\MonitoringEngine;
use Modules\Administration\Engines\RestoreEngine;
use Modules\Administration\Engines\SecurityEngine;
use Modules\Administration\Services\ConfigurationCache;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Services\FeatureToggleService;
use Modules\Administration\Support\ConfigurationRegistry;
use Modules\Administration\Support\EnvironmentResolver;
use Modules\Administration\Support\ModuleRegistry;
use Modules\Administration\Support\SystemCapabilityRegistry;

final class AdministrationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        foreach ([ConfigurationRegistry::class, ConfigurationCache::class, ConfigurationValidator::class, ConfigurationEngine::class, FeatureToggleService::class, SecurityEngine::class, MonitoringEngine::class, AuditEngine::class, BackupEngine::class, RestoreEngine::class, IntegrationEngine::class, HealthCheckEngine::class, ModuleRegistry::class, SystemCapabilityRegistry::class, EnvironmentResolver::class, AdministrationEngine::class] as $service) {
            $this->app->singleton($service);
        }
    }
}
