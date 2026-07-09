<?php

namespace Modules\Notifications\Controllers;

use Core\DTO\PaginationQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Notifications\Requests\StoreNotificationTemplateRequest;
use Modules\Notifications\Requests\UpdateNotificationTemplateRequest;
use Modules\Notifications\Services\NotificationTemplateService;
use Shared\Http\ApiResponse;

final class NotificationTemplateController
{
    public function __construct(private readonly NotificationTemplateService $templates)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = PaginationQuery::fromArray($request->query());

        return ApiResponse::success('Notification templates retrieved.', $this->templates->list($request->query(), $query->perPage));
    }

    public function store(StoreNotificationTemplateRequest $request): JsonResponse
    {
        return ApiResponse::success('Notification template created.', $this->templates->store($request->validated()), 201);
    }

    public function show(string $template): JsonResponse
    {
        return ApiResponse::success('Notification template retrieved.', $this->templates->detail($template));
    }

    public function update(UpdateNotificationTemplateRequest $request, string $template): JsonResponse
    {
        return ApiResponse::success('Notification template updated.', $this->templates->change($template, $request->validated()));
    }

    public function destroy(string $template): JsonResponse
    {
        $this->templates->remove($template);

        return ApiResponse::success('Notification template deleted.');
    }
}
