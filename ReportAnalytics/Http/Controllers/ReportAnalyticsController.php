<?php

namespace ReportAnalytics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use ReportAnalytics\Http\Resources\ReportAnalyticsResource;
use ReportAnalytics\Services\ReportAnalyticsService;

final class ReportAnalyticsController extends Controller
{
    public function __construct(private ReportAnalyticsService $service)
    {
    }

    public function index(Request $request): JsonResource
    {
        $this->authorizeReports();

        return new ReportAnalyticsResource($this->service->overview($this->roleSlugs($request)));
    }

    public function categories(Request $request): JsonResource
    {
        $this->authorizeReports();

        return new ReportAnalyticsResource($this->service->categories($this->roleSlugs($request)));
    }

    public function workspaces(Request $request): JsonResource
    {
        $this->authorizeReports();

        return new ReportAnalyticsResource($this->service->workspaces($this->roleSlugs($request)));
    }

    private function authorizeReports(): void
    {
        Gate::authorize('view-reports');
    }

    private function roleSlugs(Request $request): array
    {
        return $request->user()?->roles()->pluck('slug')->all() ?? [];
    }
}
