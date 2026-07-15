<?php

namespace Modules\Notifications\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    /** @return array<string, mixed> */
    public function centerSummary(): array;
}
