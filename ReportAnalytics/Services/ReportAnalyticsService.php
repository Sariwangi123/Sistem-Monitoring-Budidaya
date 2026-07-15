<?php

namespace ReportAnalytics\Services;

use Dashboard\Services\DashboardService;
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

    /** @return array<int, array<string, mixed>> */
    private function categoriesForRoles(array $roleSlugs): array
    {
        return array_values(array_filter(
            $this->categoryDefinitions(),
            fn (array $category): bool => $this->isAllowed($roleSlugs, $category['allowed_roles'])
        ));
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
