<?php

namespace Modules\Roles\Observers;

use Infrastructure\Logging\AuditLogger;
use Modules\Roles\Models\Role;

final class RoleObserver
{
    public function deleted(Role $role): void
    {
        app(AuditLogger::class)->record('observer.role.deleted', ['target_id' => $role->getKey()]);
    }
}
