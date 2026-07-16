<?php

namespace Modules\Administration\Services;

use Modules\Administration\Repositories\Contracts\AdministrationRepositoryInterface;
use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Engines\ConfigurationEngine;
use Modules\Administration\Engines\AuditEngine;
use Modules\Administration\Engines\MonitoringEngine;
use Modules\Administration\Jobs\CollectAdministrationMetricsJob;
use Modules\Administration\Support\ConfigurationRegistry;
use Modules\Administration\Services\FeatureToggleService;

final class AdministrationService
{
    public function __construct(private readonly AdministrationRepositoryInterface $administration, private readonly ConfigurationRegistry $configurationRegistry, private readonly AdministrationEngine $engine, private readonly ConfigurationEngine $configuration, private readonly FeatureToggleService $features, private readonly MonitoringEngine $monitoringEngine, private readonly AuditEngine $auditEngine)
    {
    }

    /** @return array<string, mixed> */
    public function overview(): array
    {
        $engine = $this->engine->overview();

        return [
            'module' => ['key' => 'system-administration', 'name' => 'System Administration', 'type' => 'platform_management', 'read_only_business_module' => true],
            'platform_summary' => $this->administration->platformSummary(),
            'supported_roles' => $this->administration->supportedRoles(),
            'modules' => $engine['modules'],
            'configuration_categories' => $this->configurationRegistry->categories(),
            'capabilities' => $engine['capabilities'],
            'security' => $engine['security'],
            'monitoring' => $engine['monitoring'],
            'audit' => $engine['audit'],
            'backup_restore' => ['backup' => $engine['backup'], 'restore' => $engine['restore']],
            'integration_management' => $engine['integration'],
            'health' => $engine['health'],
            'configuration_engine' => $engine['configuration'],
            'engine_metrics' => $engine['metrics'],
            'environment' => $engine['environment'],
        ];
    }

    /** @return array<string, mixed> */
    public function configurations(): array
    {
        return ['data' => ['categories' => $this->engine->overview()['configuration']['categories'], 'governance' => $this->configuration->metadata()], 'message' => 'Configurations retrieved.'];
    }

    /** @return array<string, mixed> */
    public function configuration(string $key): array
    {
        return ['data' => $this->configuration->configuration($key), 'message' => 'Configuration retrieved.'];
    }

    /** @return array<string, mixed> */
    public function updateConfiguration(string $key, array $payload): array
    {
        return ['data' => $this->configuration->update($key, $payload), 'message' => 'Configuration updated.'];
    }

    /** @return array<string, mixed> */
    public function configurationVersions(string $key): array
    {
        return ['data' => $this->configuration->versions($key), 'message' => 'Configuration versions retrieved.'];
    }

    /** @return array<string, mixed> */
    public function configurationHistory(string $key): array
    {
        return ['data' => $this->configuration->history($key), 'message' => 'Configuration history retrieved.'];
    }

    /** @return array<string, mixed> */
    public function configurationPublish(string $key): array
    {
        return ['data' => $this->configuration->publishMetadata($key), 'message' => 'Configuration publish metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function configurationRollback(string $key): array
    {
        return ['data' => $this->configuration->rollbackMetadata($key), 'message' => 'Configuration rollback metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function configurationRefresh(string $key): array
    {
        return ['data' => $this->configuration->refreshCache($key), 'message' => 'Configuration cache refresh metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function modules(?string $module = null): array
    {
        $modules = $this->engine->overview()['modules'];
        if ($module === null) return ['data' => $modules, 'message' => 'Administration modules retrieved.'];
        $definition = collect($modules)->firstWhere('key', $module) ?? abort(404, 'Administration module not found.');
        return ['data' => $definition, 'message' => 'Administration module retrieved.'];
    }

    /** @return array<string, mixed> */
    public function features(?string $feature = null, ?string $state = null): array
    {
        if ($feature === null) return ['data' => $this->features->all(), 'message' => 'Feature toggles retrieved.'];
        return ['data' => $this->features->update($feature, (string) $state), 'message' => 'Feature toggle updated.'];
    }

    /** @return array<string, mixed> */
    public function health(?string $check = null): array
    {
        $health = $this->engine->overview()['health'];
        if ($check === null) return ['data' => $health, 'message' => 'System health retrieved.'];
        $item = collect($health['checks'])->firstWhere('key', $check) ?? abort(404, 'Health check not found.');
        return ['data' => $item, 'message' => 'Health check retrieved.'];
    }

    /** @return array<string, mixed> */
    public function security(?string $section = null): array
    {
        $data = match ($section) { 'permissions' => $this->administration->permissions(), 'roles' => $this->administration->supportedRoles(), default => $this->engine->overview()['security'] };
        return ['data' => $data, 'message' => 'Security metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function monitoring(?string $check = null): array
    {
        $monitoring = $this->engine->overview()['monitoring'];
        if ($check === null) return ['data' => $monitoring, 'message' => 'Monitoring metadata retrieved.'];
        $item = collect($monitoring['checks'])->firstWhere('key', $check) ?? abort(404, 'Monitoring check not found.');
        return ['data' => $item, 'message' => 'Monitoring check retrieved.'];
    }

    /** @return array<string, mixed> */
    public function monitoringSummary(): array
    {
        return ['data' => ['summary' => $this->monitoringEngine->health(), 'background_job' => ['class' => CollectAdministrationMetricsJob::class, 'queue' => 'default', 'requires_worker_for_tests' => false]], 'message' => 'Monitoring summary retrieved.'];
    }

    /** @return array<string, mixed> */
    public function performance(): array
    {
        return ['data' => $this->monitoringEngine->performance(), 'message' => 'Performance monitoring retrieved.'];
    }

    /** @return array<string, mixed> */
    public function capacity(): array
    {
        return ['data' => $this->monitoringEngine->capacity(), 'message' => 'Capacity monitoring retrieved.'];
    }

    /** @return array<string, mixed> */
    public function alerts(): array
    {
        return ['data' => $this->monitoringEngine->alerts(), 'message' => 'Alert monitoring retrieved.'];
    }

    /** @return array<string, mixed> */
    public function audit(bool $statistics = false): array
    {
        $audit = $this->engine->overview()['audit'];
        return ['data' => $statistics ? ['immutable' => $audit['immutable'], 'tracked_event_types' => count($audit['events'])] : $audit, 'message' => 'Audit metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function auditCenter(): array
    {
        return ['data' => $this->auditEngine->center(), 'message' => 'Audit center retrieved.'];
    }

    /** @return array<string, mixed> */
    public function healthScore(): array
    {
        return ['data' => $this->engine->overview()['health'], 'message' => 'System health score retrieved.'];
    }

    /** @return array<string, mixed> */
    public function operationalDashboard(): array
    {
        $overview = $this->overview();
        $health = $this->engine->overview()['health'];

        return ['data' => [
            'system_health_score' => $health['score'],
            'system_health_status' => $health['status'],
            'active_user_metadata' => $overview['platform_summary']['active_users'] ?? 0,
            'queue_status' => collect($health['checks'])->firstWhere('key', 'queue'),
            'backup_status' => $overview['backup_restore']['backup']['production_operations_enabled'] === false ? 'metadata_only' : 'ready',
            'security_alerts' => collect($this->monitoringEngine->alerts()['items'])->where('source', 'security')->values()->all(),
            'capacity_trend' => $this->monitoringEngine->capacity()['items'],
        ], 'message' => 'Operational dashboard metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function backup(bool $history = false): array
    {
        return ['data' => $history ? ['items' => [], 'production_history_enabled' => false] : $this->engine->overview()['backup'], 'message' => 'Backup metadata retrieved.'];
    }

    /** @return array<string, mixed> */
    public function integration(): array
    {
        return ['data' => $this->engine->overview()['integration'], 'message' => 'Integration metadata retrieved.'];
    }

}
