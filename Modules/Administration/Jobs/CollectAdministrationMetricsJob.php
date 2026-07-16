<?php

namespace Modules\Administration\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\Administration\Engines\MonitoringEngine;

final class CollectAdministrationMetricsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 1;

    public function handle(MonitoringEngine $monitoring): void
    {
        Log::info('Administration metrics collection completed.', [
            'monitoring_checks' => count($monitoring->health()['checks']),
            'performance_metrics' => count($monitoring->performance()['metrics']),
            'capacity_items' => count($monitoring->capacity()['items']),
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::warning('Administration metrics collection failed.', ['error' => $exception->getMessage()]);
    }
}
