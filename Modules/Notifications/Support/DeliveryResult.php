<?php

namespace Modules\Notifications\Support;

final readonly class DeliveryResult
{
    /** @param array<string, mixed> $metadata */
    public function __construct(
        public string $channel,
        public string $status,
        public array $metadata = [],
        public ?string $error = null
    ) {
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'channel' => $this->channel,
            'status' => $this->status,
            'metadata' => $this->metadata,
            'error' => $this->error,
        ];
    }
}
