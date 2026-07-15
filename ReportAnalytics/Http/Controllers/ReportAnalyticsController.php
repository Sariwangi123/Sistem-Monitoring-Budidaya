<?php

namespace ReportAnalytics\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use ReportAnalytics\Http\Requests\ReportExportRequest;
use ReportAnalytics\Http\Requests\ReportGenerateRequest;
use ReportAnalytics\Http\Requests\ReportQueryRequest;
use ReportAnalytics\Http\Requests\ReportScheduleRequest;
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

    public function registry(ReportQueryRequest $request): JsonResource
    {
        $this->authorizeReports();

        return new ReportAnalyticsResource($this->service->registry($this->roleSlugs($request), $request->validated()));
    }

    public function registryDetail(Request $request, string $report): JsonResource
    {
        $this->authorizeReports();
        $definition = $this->service->definitionFor($report);
        Gate::authorize('view-report-category', [$definition->category]);

        return new ReportAnalyticsResource($this->service->registryDetail($report));
    }

    public function operational(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'operational');
    }

    public function production(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'production');
    }

    public function inventory(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'inventory');
    }

    public function harvest(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'harvest');
    }

    public function finance(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'financial');
    }

    public function executive(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'executive');
    }

    public function kpi(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'kpi');
    }

    public function audit(ReportQueryRequest $request): JsonResource
    {
        return $this->categoryResponse($request, 'audit');
    }

    public function historical(ReportQueryRequest $request): JsonResource
    {
        Gate::authorize('view-report-category', ['historical']);

        return new ReportAnalyticsResource($this->service->historical($request->validated()));
    }

    public function comparative(ReportQueryRequest $request): JsonResource
    {
        Gate::authorize('view-report-category', ['comparative']);

        return new ReportAnalyticsResource($this->service->comparative($request->validated()));
    }

    public function analytics(ReportQueryRequest $request): JsonResource
    {
        Gate::authorize('view-report-category', ['analytics']);

        return new ReportAnalyticsResource($this->service->analytics($request->validated()));
    }

    public function generate(ReportGenerateRequest $request): JsonResource
    {
        $definition = $this->service->definitionFor($request->validated('report_type'));
        Gate::authorize('generate-report', [$definition->category]);

        return new ReportAnalyticsResource($this->service->generate($request->validated()));
    }

    public function export(ReportExportRequest $request, string $report): JsonResource
    {
        $definition = $this->service->definitionFor($report);
        Gate::authorize('export-report', [$definition->category]);

        return new ReportAnalyticsResource($this->service->exportMetadata($report, $request->validated()));
    }

    public function schedules(ReportQueryRequest $request): JsonResource
    {
        Gate::authorize('schedule-report');

        return new ReportAnalyticsResource($this->service->schedules($request->validated()));
    }

    public function storeSchedule(ReportScheduleRequest $request): JsonResource
    {
        Gate::authorize('schedule-report');

        return new ReportAnalyticsResource($this->service->createSchedule($request->validated()));
    }

    public function destroySchedule(Request $request, string $uuid): JsonResource
    {
        Gate::authorize('schedule-report');

        return new ReportAnalyticsResource($this->service->deleteSchedule($uuid));
    }

    private function authorizeReports(): void
    {
        Gate::authorize('view-reports');
    }

    private function categoryResponse(ReportQueryRequest $request, string $category): JsonResource
    {
        Gate::authorize('view-report-category', [$category]);

        return new ReportAnalyticsResource($this->service->categoryReport($category, $request->validated()));
    }

    private function roleSlugs(Request $request): array
    {
        return $request->user()?->roles()->pluck('slug')->all() ?? [];
    }
}
