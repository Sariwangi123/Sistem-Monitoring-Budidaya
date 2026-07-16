<?php

namespace Modules\Administration\Engines;

final class BackupEngine
{
    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['enabled' => false, 'production_operations_enabled' => false, 'background_job_ready' => true, 'capabilities' => ['database_backup', 'file_backup', 'backup_verification', 'backup_schedule']];
    }
}
