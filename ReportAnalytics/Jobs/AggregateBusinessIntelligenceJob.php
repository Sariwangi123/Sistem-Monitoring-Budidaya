<?php

namespace ReportAnalytics\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ReportAnalytics\Services\BusinessIntelligenceService;

final class AggregateBusinessIntelligenceJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public function __construct(
        private array $filters = [],
        private array $roleSlugs = [],
        private ?int $userId = null
    ) {
    }

    public function handle(BusinessIntelligenceService $service): void
    {
        $service->overview($this->filters, $this->roleSlugs, $this->userId);
    }
}
