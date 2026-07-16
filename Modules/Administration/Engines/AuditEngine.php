<?php

namespace Modules\Administration\Engines;

final class AuditEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['immutable' => true, 'deletion_allowed' => false, 'events' => ['login', 'logout', 'configuration_change', 'role_change', 'permission_change', 'user_activity', 'api_activity', 'backup_activity', 'security_activity'], 'classifications' => ['security_audit', 'configuration_audit', 'user_audit', 'operational_audit', 'api_audit', 'backup_audit']];
    }

    /** @return array<string, mixed> */
    public function center(): array
    {
        return ['immutable' => true, 'write_api_enabled' => false, 'delete_api_enabled' => false, 'classifications' => $this->metadata()['classifications'], 'items' => [
            ['event' => 'configuration_change', 'classification' => 'configuration_audit', 'severity' => 'medium', 'source' => 'administration'],
            ['event' => 'api_activity', 'classification' => 'api_audit', 'severity' => 'information', 'source' => 'rest_api'],
            ['event' => 'security_activity', 'classification' => 'security_audit', 'severity' => 'high', 'source' => 'rbac'],
        ]];
    }
}
