<?php

namespace Modules\Administration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class BackupOrchestrationJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function handle(): void
    {
        Log::info('Administration backup orchestration dry-run completed.', ['mode' => 'metadata_only', 'production_backup_executed' => false]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::warning('Administration backup orchestration dry-run failed.', ['error' => $exception->getMessage(), 'destructive_operation' => false]);
    }
}
