<?php

namespace Dashboard\Http\Controllers;

use Dashboard\Exceptions\WidgetPermissionException;
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
            $this->validatedWithActor($request)
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
            $this->validatedWithActor($request)
        ));
    }

    public function kpi(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->kpi($this->roleSlugs($request), $this->validatedWithActor($request)));
    }

    public function widgets(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->widgets($this->roleSlugs($request), $this->validatedWithActor($request)));
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

        try {
            $container = $this->service->refreshWidget($widget, $this->roleSlugs($request), $this->validatedWithActor($request));
        } catch (WidgetPermissionException) {
            abort(403, 'Widget is not available for the current role');
        }

        if (! $container) {
            abort(404, 'Widget not found');
        }

        return new DashboardWidgetResource($container);
    }

    public function alerts(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->alerts($this->roleSlugs($request), $this->validatedWithActor($request)));
    }

    public function timeline(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->timeline($this->roleSlugs($request), $this->validatedWithActor($request)));
    }

    public function analytics(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->analytics($this->roleSlugs($request), $this->validatedWithActor($request)));
    }

    public function intelligence(DashboardQueryRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->intelligence($this->roleSlugs($request), $this->validatedWithActor($request)));
    }

    public function refresh(DashboardRefreshRequest $request): JsonResource
    {
        $this->authorizeDashboard($request, $request->validated('workspace'));

        return new DashboardApiResource($this->service->refreshDashboard(
            $this->roleSlugs($request),
            $this->validatedWithActor($request)
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

        return new DashboardApiResource($this->service->export($this->roleSlugs($request), $this->validatedWithActor($request)));
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

    private function validatedWithActor(Request $request): array
    {
        $filters = method_exists($request, 'validated') ? $request->validated() : $request->query();
        $filters['_actor_id'] = $request->user()?->getAuthIdentifier();

        return array_filter(
            $filters,
            fn ($value): bool => $value !== null && $value !== ''
        );
    }
}
