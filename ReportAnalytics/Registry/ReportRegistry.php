<?php

namespace ReportAnalytics\Registry;

use ReportAnalytics\Support\ReportDefinition;

final class ReportRegistry
{
    /** @var array<string, ReportDefinition> */
    private array $reports = [];

    public function __construct()
    {
        foreach ($this->defaultReports() as $report) {
            $this->register($report);
        }
    }

    public function register(ReportDefinition $definition): void
    {
        $this->reports[$definition->id] = $definition;
    }

    public function get(string $id): ?ReportDefinition
    {
        return $this->reports[$id] ?? null;
    }

    /** @return array<int, ReportDefinition> */
    public function all(): array
    {
        return array_values($this->reports);
    }

    /** @return array<int, ReportDefinition> */
    public function visibleForRoles(array $roleSlugs): array
    {
        return array_values(array_filter(
            $this->all(),
            fn (ReportDefinition $definition): bool => $this->isAllowed($roleSlugs, $definition->allowedRoles)
        ));
    }

    /** @return array<int, ReportDefinition> */
    private function defaultReports(): array
    {
        return [
            new ReportDefinition('executive-summary', 'Executive Summary', 'executive', 'Dashboard', 'executive-summary', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'viewer']),
            new ReportDefinition('operational-activity', 'Operational Activity Report', 'operational', 'Activities', 'operational-activity', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            new ReportDefinition('production-performance', 'Production Performance Report', 'production', 'Culture Cycle', 'production-performance', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            new ReportDefinition('inventory-stock', 'Inventory Stock Report', 'inventory', 'Warehouse', 'inventory-stock', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-manager', 'warehouse-staff']),
            new ReportDefinition('harvest-summary', 'Harvest Summary Report', 'harvest', 'Harvest', 'harvest-summary', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician']),
            new ReportDefinition('financial-performance', 'Financial Performance Report', 'financial', 'Finance', 'financial-performance', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'finance-staff']),
            new ReportDefinition('kpi-scorecard', 'KPI Scorecard Report', 'kpi', 'Dashboard', 'kpi-scorecard', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer']),
            new ReportDefinition('audit-trail', 'Audit Trail Report', 'audit', 'System', 'audit-trail', 'view-reports', ['pdf', 'xlsx', 'csv', 'json'], false, '1.0', ['super-admin']),
        ];
    }

    private function isAllowed(array $roleSlugs, array $allowedRoles): bool
    {
        return in_array('super-admin', $roleSlugs, true)
            || array_intersect($roleSlugs, $allowedRoles) !== [];
    }
}
