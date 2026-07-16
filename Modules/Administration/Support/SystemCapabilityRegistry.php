<?php

namespace Modules\Administration\Support;

final class SystemCapabilityRegistry
{
    /** @return array<int, array<string, mixed>> */
    public function definitions(): array
    {
        return [
            ['key' => 'configuration_registry', 'available' => true, 'mode' => 'metadata_foundation'],
            ['key' => 'security_engine', 'available' => true, 'mode' => 'existing_rbac_adapter'],
            ['key' => 'monitoring_engine', 'available' => true, 'mode' => 'read_only_metadata'],
            ['key' => 'audit_engine', 'available' => true, 'mode' => 'immutable_metadata'],
            ['key' => 'backup_engine', 'available' => false, 'mode' => 'foundation_only'],
            ['key' => 'restore_engine', 'available' => false, 'mode' => 'foundation_only'],
            ['key' => 'integration_engine', 'available' => false, 'mode' => 'adapter_metadata_only'],
        ];
    }
}
