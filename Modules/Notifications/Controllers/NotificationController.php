<?php

namespace Modules\Notifications\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Modules\Notifications\Models\NotificationPreference;
use Modules\Notifications\Requests\NotificationPreferenceRequest;
use Modules\Notifications\Requests\NotificationQueryRequest;
use Modules\Notifications\Resources\NotificationApiResource;
use Modules\Notifications\Resources\NotificationHistoryResource;
use Modules\Notifications\Resources\NotificationOverviewResource;
use Modules\Notifications\Resources\NotificationRecordResource;
use Modules\Notifications\Services\NotificationService;

final class NotificationController
{
    public function __construct(private NotificationService $notifications)
    {
    }

    public function overview(Request $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationOverviewResource($this->notifications->overview($this->roleSlugs($request)));
    }

    public function index(NotificationQueryRequest $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notifications retrieved.',
            ...$this->paginatedRecords($this->notifications->list($request->user(), $request->validated()), $request),
            'total_unread' => $this->notifications->statistics($request->user(), [])['total_unread'],
        ]);
    }

    public function show(Request $request, string $notification): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification retrieved.',
            'data' => (new NotificationRecordResource($this->notifications->detail($request->user(), $notification)))->resolve($request),
        ]);
    }

    public function read(Request $request, string $notification): JsonResource
    {
        Gate::authorize('update-notification-status');

        return new NotificationApiResource([
            'message' => 'Notification marked as read.',
            'data' => (new NotificationRecordResource($this->notifications->markAsRead($request->user(), $notification)))->resolve($request),
        ]);
    }

    public function readAll(Request $request): JsonResource
    {
        Gate::authorize('update-notification-status');

        return new NotificationApiResource([
            'message' => 'Notifications marked as read.',
            'data' => $this->notifications->markAllAsRead($request->user()),
        ]);
    }

    public function archive(Request $request, string $notification): JsonResource
    {
        Gate::authorize('update-notification-status');

        return new NotificationApiResource([
            'message' => 'Notification archived.',
            'data' => (new NotificationRecordResource($this->notifications->archive($request->user(), $notification)))->resolve($request),
        ]);
    }

    public function archiveAll(Request $request): JsonResource
    {
        Gate::authorize('update-notification-status');

        return new NotificationApiResource([
            'message' => 'Read notifications archived.',
            'data' => $this->notifications->archiveAll($request->user()),
        ]);
    }

    public function destroy(Request $request, string $notification): JsonResource
    {
        Gate::authorize('delete-notifications');

        return new NotificationApiResource([
            'message' => 'Notification deleted.',
            'data' => $this->notifications->delete($request->user(), $notification),
        ]);
    }

    public function preferences(Request $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification preferences retrieved.',
            'data' => $this->preferenceData($this->notifications->preferences($request->user())),
        ]);
    }

    public function updatePreferences(NotificationPreferenceRequest $request): JsonResource
    {
        Gate::authorize('update-notification-preferences');

        return new NotificationApiResource([
            'message' => 'Notification preferences updated.',
            'data' => $this->preferenceData($this->notifications->updatePreferences($request->user(), $request->validated())),
        ]);
    }

    public function history(NotificationQueryRequest $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification history retrieved.',
            ...$this->paginatedHistory($this->notifications->history($request->user(), $request->validated()), $request),
        ]);
    }

    public function search(NotificationQueryRequest $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification search completed.',
            ...$this->paginatedRecords($this->notifications->list($request->user(), $request->validated()), $request),
        ]);
    }

    public function statistics(NotificationQueryRequest $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification statistics retrieved.',
            'data' => $this->notifications->statistics($request->user(), $request->validated()),
        ]);
    }

    public function retry(Request $request, string $notification): JsonResource
    {
        Gate::authorize('retry-notifications');

        return new NotificationApiResource([
            'message' => 'Notification retry requested.',
            'data' => (new NotificationRecordResource($this->notifications->retry($request->user(), $notification)))->resolve($request),
        ]);
    }

    public function registry(Request $request): JsonResource
    {
        Gate::authorize('manage-notification-registry');

        return new NotificationApiResource([
            'message' => 'Notification registry retrieved.',
            'data' => $this->notifications->registry(),
        ]);
    }

    public function templates(Request $request): JsonResource
    {
        Gate::authorize('manage-notification-registry');

        return new NotificationApiResource([
            'message' => 'Notification templates retrieved.',
            'data' => $this->notifications->templates(),
        ]);
    }

    public function export(NotificationQueryRequest $request): JsonResource
    {
        Gate::authorize('view-notifications');

        return new NotificationApiResource([
            'message' => 'Notification export metadata retrieved.',
            'data' => $this->notifications->exportMetadata($request->user(), $request->validated()),
        ]);
    }

    private function roleSlugs(Request $request): array
    {
        return $request->user()?->roles()->pluck('slug')->all() ?? [];
    }

    private function paginatedRecords(LengthAwarePaginator $paginator, Request $request): array
    {
        return [
            'data' => array_map(
                fn ($record): array => (new NotificationRecordResource($record))->resolve($request),
                $paginator->items()
            ),
            'pagination' => $this->pagination($paginator),
        ];
    }

    private function paginatedHistory(LengthAwarePaginator $paginator, Request $request): array
    {
        return [
            'data' => array_map(
                fn ($history): array => (new NotificationHistoryResource($history))->resolve($request),
                $paginator->items()
            ),
            'pagination' => $this->pagination($paginator),
        ];
    }

    private function pagination(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'last_page' => $paginator->lastPage(),
        ];
    }

    private function preferenceData(NotificationPreference $preference): array
    {
        return [
            'id' => $preference->uuid,
            'in_app_enabled' => $preference->in_app_enabled,
            'reminder_enabled' => $preference->reminder_enabled,
            'sound_enabled' => $preference->sound_enabled,
            'email_enabled' => false,
            'whatsapp_enabled' => false,
            'desktop_notification_enabled' => false,
            'external_channel_delivery_enabled' => false,
        ];
    }
}
