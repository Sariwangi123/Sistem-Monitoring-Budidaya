<?php

namespace Modules\Administration\Services;

use Modules\Administration\Repositories\Contracts\AdministrationRepositoryInterface;
use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Engines\ConfigurationEngine;
use Modules\Administration\Support\ConfigurationRegistry;
use Modules\Administration\Services\FeatureToggleService;

final class AdministrationService
{
    public function __construct(private readonly AdministrationRepositoryInterface $administration, private readonly ConfigurationRegistry $configurationRegistry, private readonly AdministrationEngine $engine, private readonly ConfigurationEngine $configuration, private readonly FeatureToggleService $features)
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
            'environment' => $engine['environment'],
        ];
    }

    /** @return array<string, mixed> */
    public function configurations(): array
    {
        return ['data' => $this->engine->overview()['configuration']['categories'], 'message' => 'Configurations retrieved.'];
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
    public function audit(bool $statistics = false): array
    {
        $audit = $this->engine->overview()['audit'];
        return ['data' => $statistics ? ['immutable' => $audit['immutable'], 'tracked_event_types' => count($audit['events'])] : $audit, 'message' => 'Audit metadata retrieved.'];
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
