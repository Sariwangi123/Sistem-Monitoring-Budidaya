<?php

namespace Dashboard\Http\Controllers;

use Dashboard\Http\Requests\DashboardExportRequest;
use Dashboard\Http\Requests\DashboardQueryRequest;
use Dashboard\Http\Requests\DashboardRefreshRequest;
use Dashboard\Http\Resources\DashboardApiResource;
use Dashboard\Http\Resources\DashboardResource;
use Dashboard\Http\Resources\DashboardWidgetResource;
use Dashboard\Http\Resources\DashboardWorkspaceResource;
use Dashboard\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

final class DashboardController extends Controller
{
    public function __construct(private DashboardService $service)
    {
    }

    public function index(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request);

        return new DashboardApiResource($this->service->home(
            $this->roleSlugs($request),
            $request->validated()
        ));
    }

    public function snapshot(Request $request): JsonResource
    {
        $perPage = min(max($request->integer('per_page', 15), 1), 100);

        return new DashboardResource($this->service->getOperationalSnapshot($perPage));
    }

    public function workspace(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardWorkspaceResource($this->service->getWorkspace(
            $this->roleSlugs($request),
            $request->validated('workspace'),
            min(max($request->integer('per_page', 15), 1), 100)
        ));
    }

    public function workspaceByKey(DashboardQueryRequest $request, string $workspace): JsonResource
    {
        $this->authorizeDashboard($request, $workspace);

        return new DashboardApiResource($this->service->workspacePayload(
            $workspace,
            $this->roleSlugs($request),
            $request->validated()
        ));
    }

    public function kpi(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->kpi($this->roleSlugs($request), $request->validated()));
    }

    public function widgets(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->widgets($this->roleSlugs($request), $request->validated()));
    }

    public function widgetDetail(Request $request, string $widget): JsonResource
    {
        $this->authorizeDashboard($request);
        $definition = $this->service->widgetDetail($widget);

        if (! $definition) {
            abort(404, 'Widget not found');
        }

        return new DashboardApiResource([
            'data' => $definition,
            'message' => 'Success',
        ]);
    }

    public function refreshWidget(DashboardRefreshRequest $request, string $widget): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));
        $container = $this->service->refreshWidget($widget, $this->roleSlugs($request), $request->validated());

        if (! $container) {
            abort(404, 'Widget not found');
        }

        return new DashboardWidgetResource($container);
    }

    public function alerts(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->alerts($this->roleSlugs($request), $request->validated()));
    }

    public function timeline(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->timeline($this->roleSlugs($request), $request->validated()));
    }

    public function analytics(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->analytics($this->roleSlugs($request), $request->validated()));
    }

    public function refresh(DashboardRefreshRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->refreshDashboard(
            $this->roleSlugs($request),
            $request->validated()
        ));
    }

    public function cacheStatus(Request $request): JsonResource
    {
        $this->authorizeDashboard($request);

        return new DashboardApiResource($this->service->cacheStatus());
    }

    public function clearCache(Request $request): JsonResource
    {
        Gate::authorize('clear-dashboard-cache');

        return new DashboardApiResource($this->service->clearCache());
    }

    public function statistics(Request $request): JsonResource
    {
        $this->authorizeDashboard($request);

        return new DashboardApiResource($this->service->statistics());
    }

    public function export(DashboardExportRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->export($this->roleSlugs($request), $request->validated()));
    }

    private function authorizeDashboard(Request $request, ?string $workspace = null): void
    {
        $workspace ??= $request->query('workspace');

        if ($workspace) {
            Gate::authorize('view-dashboard', [$workspace]);

            return;
        }

        Gate::authorize('view-dashboard');
    }

    private function roleSlugs(Request $request): array
    {
        return $request->user()?->roles()->pluck('slug')->all() ?? [];
    }
}
