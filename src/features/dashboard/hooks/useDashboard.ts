import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { dashboardService } from '../services/dashboardService';
import type { DashboardFilters, DashboardWorkspaceKey } from '../types/dashboard';

const dashboardKeys = {
  all: ['dashboard'] as const,
  home: (filters: DashboardFilters) => [...dashboardKeys.all, 'home', filters] as const,
  workspace: (workspace: DashboardWorkspaceKey, filters: DashboardFilters) =>
    [...dashboardKeys.all, 'workspace', workspace, filters] as const,
  kpi: (filters: DashboardFilters) => [...dashboardKeys.all, 'kpi', filters] as const,
  widgets: (filters: DashboardFilters) => [...dashboardKeys.all, 'widgets', filters] as const,
  alerts: (filters: DashboardFilters) => [...dashboardKeys.all, 'alerts', filters] as const,
  timeline: (filters: DashboardFilters) => [...dashboardKeys.all, 'timeline', filters] as const,
  analytics: (filters: DashboardFilters) => [...dashboardKeys.all, 'analytics', filters] as const,
  cacheStatus: () => [...dashboardKeys.all, 'cache-status'] as const,
  statistics: () => [...dashboardKeys.all, 'statistics'] as const,
};

export function useDashboardWorkspace(workspace: DashboardWorkspaceKey, filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.workspace(workspace, filters),
    queryFn: () => dashboardService.workspace(workspace, filters),
    staleTime: 30_000,
  });
}

export function useDashboardHome(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.home(filters),
    queryFn: () => dashboardService.home(filters),
    staleTime: 30_000,
  });
}

export function useDashboardKpi(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.kpi(filters),
    queryFn: () => dashboardService.kpi(filters),
    staleTime: 30_000,
  });
}

export function useDashboardWidgets(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.widgets(filters),
    queryFn: () => dashboardService.widgets(filters),
    staleTime: 30_000,
  });
}

export function useDashboardAlerts(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.alerts(filters),
    queryFn: () => dashboardService.alerts(filters),
    staleTime: 30_000,
  });
}

export function useDashboardTimeline(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.timeline(filters),
    queryFn: () => dashboardService.timeline(filters),
    staleTime: 30_000,
  });
}

export function useDashboardAnalytics(filters: DashboardFilters) {
  return useQuery({
    queryKey: dashboardKeys.analytics(filters),
    queryFn: () => dashboardService.analytics(filters),
    staleTime: 30_000,
  });
}

export function useDashboardCacheStatus() {
  return useQuery({
    queryKey: dashboardKeys.cacheStatus(),
    queryFn: () => dashboardService.cacheStatus(),
    staleTime: 30_000,
  });
}

export function useDashboardStatistics() {
  return useQuery({
    queryKey: dashboardKeys.statistics(),
    queryFn: () => dashboardService.statistics(),
    staleTime: 30_000,
  });
}

export function useRefreshDashboard() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (filters: DashboardFilters) => dashboardService.refresh(filters),
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: dashboardKeys.all });
    },
  });
}

export function useRefreshDashboardWidget() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: ({ widgetKey, filters }: { widgetKey: string; filters: DashboardFilters }) =>
      dashboardService.refreshWidget(widgetKey, filters),
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: dashboardKeys.all });
    },
  });
}

export function useExportDashboard() {
  return useMutation({
    mutationFn: (filters: DashboardFilters & { format: 'pdf' | 'excel' | 'csv' }) =>
      dashboardService.exportDashboard(filters),
  });
}
