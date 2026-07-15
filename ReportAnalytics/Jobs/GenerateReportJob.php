<?php

namespace ReportAnalytics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ReportAnalytics\Engines\UniversalReportEngine;
use ReportAnalytics\Support\ReportRequest;

final class GenerateReportJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(private ReportRequest $request)
    {
    }

    public function handle(UniversalReportEngine $engine): void
    {
        $engine->generate($this->request);
    }
}
