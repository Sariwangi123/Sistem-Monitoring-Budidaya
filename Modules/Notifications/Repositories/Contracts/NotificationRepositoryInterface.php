<?php

namespace Modules\Notifications\Repositories\Contracts;

interface NotificationRepositoryInterface
{
    /** @return array<string, mixed> */
    public function centerSummary(): array;

    /** @param array<string, mixed> $filters */
    public function paginateForUser(\Modules\Users\Models\User $user, array $filters, int $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function findForUser(\Modules\Users\Models\User $user, string $uuid): ?\Modules\Notifications\Models\NotificationRecord;

    /** @param array<string, mixed> $filters */
    public function historyForUser(\Modules\Users\Models\User $user, array $filters, int $perPage): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    /** @param array<string, mixed> $filters */
    public function countForUser(\Modules\Users\Models\User $user, array $filters = []): int;

    /** @param array<string, mixed> $filters */
    public function statisticsForUser(\Modules\Users\Models\User $user, array $filters = []): array;

    public function markAllReadableAsRead(\Modules\Users\Models\User $user): int;

    public function archiveAllRead(\Modules\Users\Models\User $user): int;

    public function deleteRecord(\Modules\Notifications\Models\NotificationRecord $record): void;

    public function preferenceForUser(\Modules\Users\Models\User $user): \Modules\Notifications\Models\NotificationPreference;

    /** @param array<string, mixed> $payload */
    public function updatePreference(\Modules\Users\Models\User $user, array $payload): \Modules\Notifications\Models\NotificationPreference;

    /** @return array<int, \Modules\Notifications\Models\NotificationTemplate> */
    public function activeTemplates(): array;

    /** @param array<string, mixed> $payload */
    public function createRecord(array $payload): \Modules\Notifications\Models\NotificationRecord;

    /** @param array<string, mixed> $metadata */
    public function updateRecordStatus(\Modules\Notifications\Models\NotificationRecord $record, string $status, array $metadata = [], ?string $error = null): \Modules\Notifications\Models\NotificationRecord;

    /** @param array<string, mixed> $payload */
    public function addHistory(\Modules\Notifications\Models\NotificationRecord $record, array $payload): \Modules\Notifications\Models\NotificationHistory;
}
