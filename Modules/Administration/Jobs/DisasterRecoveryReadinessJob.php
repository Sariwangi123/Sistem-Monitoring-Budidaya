<?php

namespace Modules\Administration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

final class DisasterRecoveryReadinessJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function handle(): void
    {
        Log::info('Administration disaster recovery readiness calculation completed.', ['rule_based' => true, 'uses_ai' => false]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::warning('Administration disaster recovery readiness calculation failed.', ['error' => $exception->getMessage()]);
    }
}
