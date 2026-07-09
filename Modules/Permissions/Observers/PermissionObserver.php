<?php

namespace Modules\Permissions\Observers;

use Infrastructure\Logging\AuditLogger;
use Modules\Permissions\Models\Permission;

final class PermissionObserver
{
    public function deleted(Permission $permission): void
    {
        app(AuditLogger::class)->record('observer.permission.deleted', ['target_id' => $permission->getKey()]);
    }
}
