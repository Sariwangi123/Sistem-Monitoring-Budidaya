<?php

namespace Modules\Administration\Services;

use Modules\Administration\Repositories\Contracts\AdministrationRepositoryInterface;
use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Support\ConfigurationRegistry;

final class AdministrationService
{
    public function __construct(private readonly AdministrationRepositoryInterface $administration, private readonly ConfigurationRegistry $configurationRegistry, private readonly AdministrationEngine $engine)
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
}
