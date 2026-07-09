<?php

namespace Modules\Settings\Controllers;

use Core\DTO\PaginationQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Settings\Requests\StoreGlobalSettingRequest;
use Modules\Settings\Requests\UpdateGlobalSettingRequest;
use Modules\Settings\Services\GlobalSettingService;
use Shared\Http\ApiResponse;

final class GlobalSettingController
{
    public function __construct(private readonly GlobalSettingService $settings)
    {
    }

    public function index(Request $request): JsonResponse
    {
        $query = PaginationQuery::fromArray($request->query());

        return ApiResponse::success('Settings retrieved.', $this->settings->list($request->query(), $query->perPage));
    }

    public function store(StoreGlobalSettingRequest $request): JsonResponse
    {
        return ApiResponse::success('Setting created.', $this->settings->store($request->validated()), 201);
    }

    public function show(string $setting): JsonResponse
    {
        return ApiResponse::success('Setting retrieved.', $this->settings->detail($setting));
    }

    public function update(UpdateGlobalSettingRequest $request, string $setting): JsonResponse
    {
        return ApiResponse::success('Setting updated.', $this->settings->change($setting, $request->validated()));
    }

    public function destroy(string $setting): JsonResponse
    {
        $this->settings->remove($setting);

        return ApiResponse::success('Setting deleted.');
    }
}
