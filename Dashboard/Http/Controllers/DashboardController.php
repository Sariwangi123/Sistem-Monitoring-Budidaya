<?php

namespace Dashboard\Http\Controllers;

use Dashboard\Http\Resources\DashboardResource;
use Dashboard\Http\Resources\DashboardWorkspaceResource;
use Dashboard\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;

final class DashboardController extends Controller
{
    public function __construct(private DashboardService $service)
    {
    }

    public function index(Request $request): JsonResource
    {
        $perPage = min(max($request->integer('per_page', 15), 1), 100);

        return new DashboardResource($this->service->getOperationalSnapshot($perPage));
    }

    public function workspace(Request $request): JsonResource
    {
        $perPage = min(max($request->integer('per_page', 15), 1), 100);
        $roleSlugs = $request->user()?->roles()->pluck('slug')->all() ?? [];

        return new DashboardWorkspaceResource($this->service->getWorkspace(
            $roleSlugs,
            $request->string('workspace')->toString() ?: null,
            $perPage
        ));
    }
}
