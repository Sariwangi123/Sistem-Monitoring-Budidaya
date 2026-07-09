<?php

namespace Modules\Users\Observers;

use Infrastructure\Logging\AuditLogger;
use Modules\Users\Models\User;

final class UserObserver
{
    public function deleted(User $user): void
    {
        app(AuditLogger::class)->record('observer.user.deleted', ['target_id' => $user->getKey()]);
    }
}
