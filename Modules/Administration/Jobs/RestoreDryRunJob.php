<?php

namespace Modules\Administration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class RestoreDryRunJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function handle(): void
    {
        Log::info('Administration restore dry-run metadata completed.', ['destructive_restore_executed' => false]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::warning('Administration restore dry-run failed.', ['error' => $exception->getMessage(), 'destructive_restore_executed' => false]);
    }
}
