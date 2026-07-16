<?php

namespace Modules\Administration\Engines;

final class AuditEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['immutable' => true, 'deletion_allowed' => false, 'events' => ['login', 'logout', 'configuration_change', 'permission_change', 'user_activity', 'api_activity', 'security_activity']];
    }
}
