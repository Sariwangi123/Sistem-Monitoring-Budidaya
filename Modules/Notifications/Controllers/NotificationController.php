<?php

namespace Modules\Notifications\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Modules\Notifications\Resources\NotificationOverviewResource;
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

    private function roleSlugs(Request $request): array
    {
        return $request->user()?->roles()->pluck('slug')->all() ?? [];
    }
}
