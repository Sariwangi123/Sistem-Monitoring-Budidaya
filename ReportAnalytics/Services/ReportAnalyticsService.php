<?php

namespace ReportAnalytics\Services;

use Dashboard\Services\DashboardService;
use Illuminate\Support\Facades\Log;
use ReportAnalytics\Engines\UniversalReportEngine;
use ReportAnalytics\Registry\ReportRegistry;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;

final class ReportAnalyticsService
{
    public function __construct(
        private DashboardService $dashboardService,
        private ReportRegistry $registry,
        private UniversalReportEngine $engine
    ) {
    }

    public function overview(array $roleSlugs): array
    {
        return [
            'data' => [
                'module' => [
                    'key' => 'report_analytics',
                    'title' => 'Report & Analytics',
                    'description' => 'Business Intelligence module for operational, historical, KPI, audit, and executive reports.',
                    'principle' => 'Generate, Never Store',
                    'read_only' => true,
                    'stores_transaction_snapshot' => false,
                    'status' => 'Foundation Ready',
                ],
                'categories' => $this->categoriesForRoles($roleSlugs),
                'workspaces' => $this->workspacesForRoles($roleSlugs),
                'data_sources' => $this->dataSources(),
                'constraints' => $this->constraints(),
                'service_layer' => $this->serviceLayer(),
                'dashboard_reference' => $this->dashboardReference(),
                'engine_architecture' => $this->engineArchitecture(),
                'registered_reports' => array_map(
                    fn (ReportDefinition $definition): array => $definition->toArray(),
                    $this->registry->visibleForRoles($roleSlugs)
                ),
            ],
            'message' => 'Report Analytics foundation retrieved.',
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
                'engine_status' => 'foundation_ready',
            ],
        ];
    }

    public function categories(array $roleSlugs): array
    {
        return [
            'data' => [
                'items' => $this->categoriesForRoles($roleSlugs),
            ],
            'message' => 'Report categories retrieved.',
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
            ],
        ];
    }

    public function workspaces(array $roleSlugs): array
    {
        return [
            'data' => [
                'items' => $this->workspacesForRoles($roleSlugs),
            ],
            'message' => 'Report workspaces retrieved.',
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
            ],
        ];
    }

    public function enginePreview(array $roleSlugs): array
    {
        $definition = $this->registry->visibleForRoles($roleSlugs)[0] ?? null;

        if (! $definition) {
            return [
                'data' => [
                    'available' => false,
                ],
                'message' => 'No report definition available for current roles.',
                'meta' => [
                    'read_only' => true,
                    'generate_never_store' => true,
                ],
            ];
        }

        return [
            'data' => $this->engine->generate(new ReportRequest($definition->id)),
            'message' => 'Report engine foundation preview generated.',
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
                'production_export' => false,
            ],
        ];
    }

    public function definitionFor(string $reportId): ReportDefinition
    {
        $definition = $this->registry->get($reportId);

        if (! $definition) {
            abort(404, 'Report definition not found');
        }

        return $definition;
    }

    public function registry(array $roleSlugs, array $filters = []): array
    {
        return $this->respond('report.registry', $roleSlugs, $filters, fn (): array => [
            'items' => array_map(
                fn (ReportDefinition $definition): array => $definition->toArray(),
                $this->filterDefinitions($this->registry->visibleForRoles($roleSlugs), $filters)
            ),
        ]);
    }

    public function registryDetail(string $reportId): array
    {
        $definition = $this->definitionFor($reportId);

        return $this->respond('report.registry.detail', [], ['report_id' => $reportId], fn (): array => [
            'item' => $definition->toArray(),
        ]);
    }

    public function categoryReport(string $category, array $filters): array
    {
        $normalizedCategory = $this->normalizeCategory($category);

        return $this->respond("report.{$normalizedCategory}", [], $filters, fn (): array => [
            'category' => $normalizedCategory,
            'reports' => array_map(
                fn (ReportDefinition $definition): array => $definition->toArray(),
                $this->definitionsForCategory($normalizedCategory)
            ),
            'filters' => $filters,
            'summary' => [
                'status' => 'Generated',
                'read_only' => true,
                'source_strategy' => 'service_layer_only',
            ],
            'sections' => $this->sectionsForCategory($normalizedCategory),
        ]);
    }

    public function historical(array $filters): array
    {
        return $this->respond('report.historical', [], $filters, fn (): array => [
            'category' => 'historical',
            'period' => $filters['period'] ?? 'monthly',
            'supported_periods' => ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'],
            'filters' => $filters,
            'trend' => [],
            'summary' => [
                'status' => 'Foundation Ready',
                'read_only' => true,
            ],
        ]);
    }

    public function comparative(array $filters): array
    {
        return $this->respond('report.comparative', [], $filters, fn (): array => [
            'category' => 'comparative',
            'comparison_scope' => [
                'farm_id' => $filters['farm_id'] ?? null,
                'pond_id' => $filters['pond_id'] ?? null,
                'culture_cycle_id' => $filters['culture_cycle_id'] ?? null,
                'financial_period_id' => $filters['financial_period_id'] ?? null,
            ],
            'filters' => $filters,
            'comparison' => [],
            'summary' => [
                'status' => 'Foundation Ready',
                'read_only' => true,
            ],
        ]);
    }

    public function analytics(array $filters): array
    {
        return $this->respond('report.analytics', [], $filters, fn (): array => [
            'category' => $filters['report_category'] ?? 'all',
            'period' => $filters['period'] ?? null,
            'summary' => [
                'status' => 'Foundation Ready',
                'read_only' => true,
            ],
            'trend' => [],
            'comparison' => [],
            'filters' => $filters,
        ]);
    }

    public function generate(array $payload): array
    {
        $definition = $this->registry->get($payload['report_type']);

        if (! $definition) {
            abort(404, 'Report definition not found');
        }

        $format = $payload['export_format'];
        $template = $payload['template'] ?? $definition->template;

        if ($template !== $definition->template) {
            abort(422, 'Template does not match report definition');
        }

        if (! in_array($format, $definition->supportedExportFormats, true)) {
            abort(422, 'Export format is not supported by this report');
        }

        return $this->respond('report.generate', [], $payload, fn (): array => $this->engine->generate(new ReportRequest(
            reportId: $definition->id,
            format: $format,
            locale: $payload['locale'] ?? 'id',
            parameters: [
                'filter' => $payload['filter'] ?? [],
                'parameter' => $payload['parameter'] ?? [],
            ]
        )), 'Report generated as preview metadata.');
    }

    public function exportMetadata(string $reportId, array $filters): array
    {
        $definition = $this->registry->get($reportId);

        if (! $definition) {
            abort(404, 'Report definition not found');
        }

        $format = $filters['format'] ?? 'pdf';

        if (! in_array($format, $definition->supportedExportFormats, true)) {
            abort(422, 'Export format is not supported by this report');
        }

        return $this->respond('report.export.metadata', [], $filters, fn (): array => [
            'report' => $definition->toArray(),
            'format' => $format,
            'adapter' => 'in_memory_metadata',
            'production_file_export' => false,
            'supported_export_formats' => $definition->supportedExportFormats,
        ], 'Report export metadata retrieved.');
    }

    public function schedules(array $filters = []): array
    {
        return $this->respond('report.schedules.index', [], $filters, fn (): array => [
            'items' => [],
            'foundation' => [
                'schedule_support' => 'contract_only',
                'production_scheduler' => false,
                'queue_job' => false,
            ],
        ], 'Report schedule foundation retrieved.');
    }

    public function createSchedule(array $payload): array
    {
        $definition = $this->registry->get($payload['report_id']);

        if (! $definition) {
            abort(404, 'Report definition not found');
        }

        return $this->respond('report.schedules.store', [], $payload, fn (): array => [
            'uuid' => (string) str()->uuid(),
            'report' => $definition->toArray(),
            'frequency' => $payload['frequency'],
            'export_format' => $payload['export_format'],
            'timezone' => $payload['timezone'] ?? config('app.timezone'),
            'filters' => $payload['filters'] ?? [],
            'status' => 'Accepted',
            'production_scheduler' => false,
        ], 'Report schedule foundation accepted.');
    }

    public function deleteSchedule(string $uuid): array
    {
        return $this->respond('report.schedules.destroy', [], ['uuid' => $uuid], fn (): array => [
            'uuid' => $uuid,
            'deleted' => true,
            'production_scheduler' => false,
        ], 'Report schedule foundation deleted.');
    }

    /** @return array<int, array<string, mixed>> */
    private function categoriesForRoles(array $roleSlugs): array
    {
        return array_values(array_filter(
            $this->categoryDefinitions(),
            fn (array $category): bool => $this->isAllowed($roleSlugs, $category['allowed_roles'])
        ));
    }

    /** @param array<int, ReportDefinition> $definitions */
    private function filterDefinitions(array $definitions, array $filters): array
    {
        $category = isset($filters['report_category']) ? $this->normalizeCategory((string) $filters['report_category']) : null;
        $search = str((string) ($filters['search'] ?? ''))->lower()->toString();

        return array_values(array_filter($definitions, function (ReportDefinition $definition) use ($category, $search): bool {
            if ($category && $definition->category !== $category) {
                return false;
            }

            if ($search === '') {
                return true;
            }

            return str_contains(strtolower($definition->name), $search)
                || str_contains(strtolower($definition->category), $search)
                || str_contains(strtolower($definition->sourceModule), $search);
        }));
    }

    /** @return array<int, ReportDefinition> */
    private function definitionsForCategory(string $category): array
    {
        return array_values(array_filter(
            $this->registry->all(),
            fn (ReportDefinition $definition): bool => $definition->category === $category
        ));
    }

    /** @return array<int, array<string, mixed>> */
    private function sectionsForCategory(string $category): array
    {
        $sections = match ($category) {
            'operational' => ['feeding', 'treatment', 'sampling', 'maintenance', 'daily_activities'],
            'production' => ['biomass', 'growth', 'sr', 'fcr', 'adg', 'production_summary'],
            'inventory' => ['current_stock', 'stock_movement', 'stock_adjustment', 'inventory_valuation', 'low_stock'],
            'harvest' => ['harvest_planning', 'harvest_summary', 'grade_distribution', 'yield', 'delivery_summary'],
            'financial' => ['expense', 'revenue', 'profit_loss', 'cost_of_production', 'cost_per_kg', 'roi'],
            'executive' => ['executive_summary', 'kpi_summary', 'production_summary', 'inventory_summary', 'harvest_summary', 'financial_summary'],
            'kpi' => ['kpi_list', 'trend', 'comparison'],
            'audit' => ['login_activity', 'user_activity', 'approval_history', 'transaction_history', 'audit_trail'],
            default => ['summary'],
        };

        return array_map(fn (string $section): array => [
            'key' => $section,
            'title' => str($section)->headline()->toString(),
            'status' => 'Foundation Ready',
            'items' => [],
        ], $sections);
    }

    private function normalizeCategory(string $category): string
    {
        return $category === 'finance' ? 'financial' : $category;
    }

    private function respond(string $scope, array $roleSlugs, array $filters, callable $callback, string $message = 'Success'): array
    {
        $startedAt = microtime(true);
        $data = $callback();
        $executionTimeMs = round((microtime(true) - $startedAt) * 1000, 2);

        Log::info('report_analytics.endpoint.executed', [
            'scope' => $scope,
            'roles' => $roleSlugs,
            'report_type' => $filters['report_type'] ?? $filters['report_id'] ?? null,
            'export_format' => $filters['export_format'] ?? $filters['format'] ?? null,
            'execution_time_ms' => $executionTimeMs,
            'file_size' => null,
            'generated_at' => now()->toISOString(),
        ]);

        return [
            'data' => $data,
            'message' => $message,
            'meta' => [
                'read_only' => true,
                'generate_never_store' => true,
                'execution_time_ms' => $executionTimeMs,
                'file_size' => null,
                'generated_at' => now()->toISOString(),
            ],
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function workspacesForRoles(array $roleSlugs): array
    {
        return array_values(array_filter(
            $this->workspaceDefinitions(),
            fn (array $workspace): bool => $this->isAllowed($roleSlugs, $workspace['allowed_roles'])
        ));
    }

    /** @return array<int, array<string, mixed>> */
    private function categoryDefinitions(): array
    {
        return [
            $this->definition('executive', 'Executive', 'Executive summary, business overview, and management KPI reports.', ['super-admin', 'farm-owner', 'director', 'viewer']),
            $this->definition('operational', 'Operational', 'Daily activities, feeding, treatment, sampling, and maintenance reports.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('production', 'Production', 'Culture cycle, biomass, growth, SR, FCR, and ADG reports.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('inventory', 'Inventory', 'Current stock, movement, adjustment, low stock, near expired, and valuation reports.', ['super-admin', 'farm-manager', 'warehouse-staff']),
            $this->definition('harvest', 'Harvest', 'Harvest planning, yield, grade distribution, packing, and delivery reports.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('financial', 'Financial', 'Expense, revenue, profit and loss, cost of production, cost per kilogram, and ROI reports.', ['super-admin', 'farm-owner', 'director', 'finance-staff']),
            $this->definition('kpi', 'KPI', 'Biomass, SR, FCR, ADG, cost per KG, gross profit, net profit, and ROI reports.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer']),
            $this->definition('audit', 'Audit', 'User activity, login history, transaction history, approval history, and audit trail reports.', ['super-admin']),
        ];
    }

    /** @return array<int, array<string, mixed>> */
    private function workspaceDefinitions(): array
    {
        return [
            $this->definition('executive', 'Executive', 'Management and executive report workspace.', ['super-admin', 'farm-owner', 'director', 'viewer']),
            $this->definition('operational', 'Operational', 'Daily operational report workspace.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('production', 'Production', 'Production performance report workspace.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('inventory', 'Inventory', 'Inventory and warehouse report workspace.', ['super-admin', 'farm-manager', 'warehouse-staff']),
            $this->definition('harvest', 'Harvest', 'Harvest operational report workspace.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            $this->definition('financial', 'Financial', 'Financial and profitability report workspace.', ['super-admin', 'farm-owner', 'director', 'finance-staff']),
            $this->definition('kpi', 'KPI', 'Cross-module KPI report workspace.', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer']),
            $this->definition('audit', 'Audit', 'Audit and compliance report workspace.', ['super-admin']),
        ];
    }

    /** @return array<string, string> */
    private function dataSources(): array
    {
        return [
            'master_data' => 'Master Data Service Layer',
            'culture_cycle' => 'Culture Cycle Service Layer',
            'activities' => 'Activities Service Layer',
            'warehouse' => 'Warehouse Service Layer',
            'harvest' => 'Harvest Service Layer',
            'finance' => 'Finance Service Layer',
            'dashboard' => 'Dashboard Service Layer',
        ];
    }

    /** @return array<int, string> */
    private function constraints(): array
    {
        return [
            'Read Only',
            'Generate Never Store',
            'No transaction creation',
            'No transaction mutation',
            'No transaction deletion',
            'No permanent transaction snapshot',
            'No direct database access from controller',
            'No production export file in Part 2',
            'No queue or scheduled report in Part 2',
            'No frontend report workspace in Part 2',
        ];
    }

    /** @return array<string, string> */
    private function serviceLayer(): array
    {
        return [
            'controller' => 'ReportAnalytics\\Http\\Controllers\\ReportAnalyticsController',
            'service' => self::class,
            'engine' => UniversalReportEngine::class,
            'registry' => ReportRegistry::class,
            'dashboard_dependency' => $this->dashboardService::class,
        ];
    }

    /** @return array<string, mixed> */
    private function engineArchitecture(): array
    {
        return [
            'universal_report_engine' => 'Foundation Ready',
            'report_registry' => 'Foundation Ready',
            'template_engine' => 'Foundation Ready',
            'template_resolver' => 'Foundation Ready',
            'report_builder' => 'Foundation Ready',
            'report_section' => 'Foundation Ready',
            'data_collector' => 'Service Layer Only',
            'data_formatter' => 'Locale Aware Foundation',
            'rendering_engine' => 'Abstraction Ready',
            'export_engine' => 'In Memory Abstraction Only',
            'report_layout' => 'Foundation Ready',
            'file_naming' => 'REPORTTYPE-YYYYMMDD-HHMMSS',
        ];
    }

    /** @return array<string, mixed> */
    private function dashboardReference(): array
    {
        return [
            'available' => true,
            'source' => 'Dashboard Service',
            'purpose' => 'Reuse completed Dashboard read-only aggregation as an upstream source for future report parts.',
        ];
    }

    /** @param array<int, string> $allowedRoles */
    private function definition(string $key, string $title, string $description, array $allowedRoles): array
    {
        return [
            'key' => $key,
            'title' => $title,
            'description' => $description,
            'status' => 'Foundation Ready',
            'read_only' => true,
            'allowed_roles' => $allowedRoles,
        ];
    }

    /** @param array<int, string> $allowedRoles */
    private function isAllowed(array $roleSlugs, array $allowedRoles): bool
    {
        return in_array('super-admin', $roleSlugs, true)
            || array_intersect($roleSlugs, $allowedRoles) !== [];
    }
}
