<?php

namespace Modules\Notifications\Support;

final readonly class RetryPolicy
{
    public function __construct(
        public int $maxAttempts = 3,
        public int $intervalSeconds = 60
    ) {
        if ($maxAttempts < 1 || $maxAttempts > 3) {
            throw new \InvalidArgumentException('Notification retry max attempts must be between 1 and 3.');
        }

        if ($intervalSeconds < 1) {
            throw new \InvalidArgumentException('Notification retry interval must be positive.');
        }
    }

    /** @return array<string, int> */
    public function toArray(): array
    {
        return [
            'max_attempts' => $this->maxAttempts,
            'interval_seconds' => $this->intervalSeconds,
        ];
    }

    /** @return array<int, int> */
    public function backoffSchedule(): array
    {
        return array_map(fn (int $attempt): int => $this->intervalSeconds * $attempt, range(1, $this->maxAttempts));
    }
}
