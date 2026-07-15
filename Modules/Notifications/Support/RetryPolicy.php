<?php

namespace Modules\Notifications\Support;

final readonly class RetryPolicy
{
    public function __construct(
        public int $maxAttempts = 3,
        public int $intervalSeconds = 60
    ) {
    }

    /** @return array<string, int> */
    public function toArray(): array
    {
        return [
            'max_attempts' => $this->maxAttempts,
            'interval_seconds' => $this->intervalSeconds,
        ];
    }
}
