<?php

namespace Modules\Notifications\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    /** @return array<string, mixed> */
    public function centerSummary(): array;

    /** @param array<string, mixed> $payload */
    public function createRecord(array $payload): \Modules\Notifications\Models\NotificationRecord;

    /** @param array<string, mixed> $metadata */
    public function updateRecordStatus(\Modules\Notifications\Models\NotificationRecord $record, string $status, array $metadata = [], ?string $error = null): \Modules\Notifications\Models\NotificationRecord;

    /** @param array<string, mixed> $payload */
    public function addHistory(\Modules\Notifications\Models\NotificationRecord $record, array $payload): \Modules\Notifications\Models\NotificationHistory;
}
