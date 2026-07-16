<?php

namespace Modules\Administration\Engines;

final class HealthCheckEngine
{
    public function __construct(private readonly MonitoringEngine $monitoring)
    {
    }

    /** @return array<string, mixed> */
    public function summary(): array
    {
        $health = $this->monitoring->health();

        return ['status' => 'ready', 'checks' => $health['checks'], 'real_time_monitoring_enabled' => false];
    }
}
