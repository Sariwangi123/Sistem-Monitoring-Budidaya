<?php

namespace Modules\Administration\Support;

final class ModuleRegistry
{
    /** @return array<int, array<string, mixed>> */
    public function definitions(): array
    {
        return [
            ['key' => 'user_management', 'name' => 'User Management', 'permission' => 'users.manage', 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'role_management', 'name' => 'Role Management', 'permission' => 'roles.manage', 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'permission_management', 'name' => 'Permission Management', 'permission' => 'permissions.manage', 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'configuration_management', 'name' => 'Configuration Management', 'permission' => 'settings.manage', 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'security_management', 'name' => 'Security Management', 'permission' => null, 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'audit_management', 'name' => 'Audit Management', 'permission' => null, 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'monitoring', 'name' => 'Monitoring', 'permission' => null, 'toggle' => FeatureToggle::ENABLED],
            ['key' => 'backup_restore', 'name' => 'Backup & Restore', 'permission' => null, 'toggle' => FeatureToggle::DISABLED],
            ['key' => 'integration_management', 'name' => 'Integration Management', 'permission' => null, 'toggle' => FeatureToggle::HIDDEN],
        ];
    }
}
