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
        $score = $this->score($health['checks']);

        return ['status' => $this->status($score), 'score' => $score, 'checks' => $health['checks'], 'scoring' => ['rule_based' => true, 'healthy' => 100, 'warning' => 70, 'critical' => 30], 'real_time_monitoring_enabled' => false];
    }

    /** @param array<int, array<string, mixed>> $checks */
    private function score(array $checks): int
    {
        $total = array_sum(array_map(fn (array $check): int => match ($check['status'] ?? 'warning') {
            'healthy' => 100,
            'critical' => 30,
            default => 70,
        }, $checks));

        return (int) round($total / max(count($checks), 1));
    }

    private function status(int $score): string
    {
        return match (true) {
            $score >= 90 => 'healthy',
            $score >= 60 => 'warning',
            default => 'critical',
        };
    }
}
