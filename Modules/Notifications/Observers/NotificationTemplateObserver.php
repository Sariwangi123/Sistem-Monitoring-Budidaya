<?php

namespace Modules\Notifications\Observers;

use Infrastructure\Logging\AuditLogger;
use Modules\Notifications\Models\NotificationTemplate;

final class NotificationTemplateObserver
{
    public function deleted(NotificationTemplate $template): void
    {
        app(AuditLogger::class)->record('observer.notification_template.deleted', ['target_id' => $template->getKey()]);
    }
}
