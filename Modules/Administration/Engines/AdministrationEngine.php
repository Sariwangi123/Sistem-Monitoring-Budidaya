<?php

namespace Modules\Administration\Engines;

use Modules\Administration\Support\EnvironmentResolver;
use Modules\Administration\Support\ModuleRegistry;
use Modules\Administration\Support\SystemCapabilityRegistry;

final class AdministrationEngine
{
    public function __construct(private readonly ConfigurationEngine $configuration, private readonly SecurityEngine $security, private readonly MonitoringEngine $monitoring, private readonly AuditEngine $audit, private readonly BackupEngine $backup, private readonly RestoreEngine $restore, private readonly IntegrationEngine $integration, private readonly HealthCheckEngine $health, private readonly ModuleRegistry $modules, private readonly SystemCapabilityRegistry $capabilities, private readonly EnvironmentResolver $environment)
    {
    }

    /** @return array<string, mixed> */
    public function overview(): array
    {
        return ['configuration' => $this->configuration->metadata(), 'security' => $this->security->metadata(), 'monitoring' => $this->monitoring->health(), 'audit' => $this->audit->metadata(), 'backup' => $this->backup->metadata(), 'restore' => $this->restore->metadata(), 'integration' => $this->integration->metadata(), 'health' => $this->health->summary(), 'modules' => $this->modules->definitions(), 'capabilities' => $this->capabilities->definitions(), 'environment' => $this->environment->resolve()];
    }
}
