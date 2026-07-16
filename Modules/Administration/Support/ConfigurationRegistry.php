<?php

namespace Modules\Administration\Support;

final class ConfigurationRegistry
{
    /** @return array<int, array<string, string>> */
    public function categories(): array
    {
        return [
            ['key' => 'general', 'name' => 'General'], ['key' => 'company', 'name' => 'Company'],
            ['key' => 'farm', 'name' => 'Farm'], ['key' => 'finance', 'name' => 'Finance'],
            ['key' => 'notification', 'name' => 'Notification'], ['key' => 'report', 'name' => 'Report'],
            ['key' => 'dashboard', 'name' => 'Dashboard'], ['key' => 'security', 'name' => 'Security'],
            ['key' => 'integration', 'name' => 'Integration'], ['key' => 'system', 'name' => 'System'],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    public function capabilities(): array
    {
        return [
            ['key' => 'configuration_registry', 'available' => true, 'mode' => 'metadata_foundation', 'single_source_of_truth' => true, 'versioning_enabled' => false],
            ['key' => 'rbac', 'available' => true, 'mode' => 'existing_platform_service'],
            ['key' => 'audit_management', 'available' => true, 'mode' => 'read_only_foundation', 'deletion_allowed' => false],
            ['key' => 'monitoring', 'available' => true, 'mode' => 'read_only_foundation'],
            ['key' => 'backup_restore', 'available' => false, 'mode' => 'metadata_only'],
            ['key' => 'integration_management', 'available' => false, 'mode' => 'metadata_only'],
        ];
    }
}
