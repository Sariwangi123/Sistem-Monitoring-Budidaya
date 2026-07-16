<?php

namespace Modules\Administration\Services;

use Modules\Administration\Repositories\Contracts\AdministrationRepositoryInterface;
use Modules\Administration\Support\ConfigurationRegistry;

final class AdministrationService
{
    public function __construct(private readonly AdministrationRepositoryInterface $administration, private readonly ConfigurationRegistry $configurationRegistry)
    {
    }

    /** @return array<string, mixed> */
    public function overview(): array
    {
        return [
            'module' => ['key' => 'system-administration', 'name' => 'System Administration', 'type' => 'platform_management', 'read_only_business_module' => true],
            'platform_summary' => $this->administration->platformSummary(),
            'supported_roles' => $this->administration->supportedRoles(),
            'modules' => $this->modules(),
            'configuration_categories' => $this->configurationRegistry->categories(),
            'capabilities' => $this->configurationRegistry->capabilities(),
            'security' => ['authentication' => 'sanctum', 'authorization' => 'existing_rbac_policy_and_gate', 'access_control' => 'permission_based'],
            'monitoring' => ['read_only' => true, 'status' => 'foundation_ready'],
            'backup_restore' => ['production_operations_enabled' => false, 'status' => 'metadata_only'],
            'integration_management' => ['external_integrations_enabled' => false, 'status' => 'metadata_only'],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function modules(): array
    {
        return [
            ['key' => 'user_management', 'name' => 'User Management', 'available' => true, 'permission' => 'users.manage'],
            ['key' => 'role_management', 'name' => 'Role Management', 'available' => true, 'permission' => 'roles.manage'],
            ['key' => 'permission_management', 'name' => 'Permission Management', 'available' => true, 'permission' => 'permissions.manage'],
            ['key' => 'configuration_management', 'name' => 'Configuration Management', 'available' => true, 'permission' => 'settings.manage'],
            ['key' => 'security_management', 'name' => 'Security Management', 'available' => true, 'permission' => null],
            ['key' => 'audit_management', 'name' => 'Audit Management', 'available' => true, 'permission' => null],
            ['key' => 'monitoring', 'name' => 'Monitoring', 'available' => true, 'permission' => null],
            ['key' => 'backup_restore', 'name' => 'Backup & Restore', 'available' => false, 'permission' => null],
            ['key' => 'integration_management', 'name' => 'Integration Management', 'available' => false, 'permission' => null],
        ];
    }
}
