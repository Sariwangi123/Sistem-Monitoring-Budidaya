<?php

namespace Modules\Settings\Observers;

use Infrastructure\Logging\AuditLogger;
use Modules\Settings\Models\GlobalSetting;

final class GlobalSettingObserver
{
    public function deleted(GlobalSetting $setting): void
    {
        app(AuditLogger::class)->record('observer.setting.deleted', ['target_id' => $setting->getKey()]);
    }
}
