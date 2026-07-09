<?php

namespace Infrastructure\Logging;

use Illuminate\Support\Facades\Log;

final class AuditLogger
{
    public function record(string $event, array $context = []): void
    {
        Log::channel('audit')->info($event, array_merge([
            'user_id' => auth()->id(),
            'ip' => request()?->ip(),
        ], $context));
    }
}
