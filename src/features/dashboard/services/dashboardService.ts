import { apiClient } from '../../../services/apiClient';
import type { ApiSuccessResponse } from '../../../types/api';
import type {
  DashboardAlertsResponse,
  DashboardAnalyticsResponse,
  DashboardCacheStatus,
  DashboardExportResult,
  DashboardFilters,
  DashboardHome,
  DashboardKpiResponse,
  DashboardRefreshResult,
  DashboardStatistics,
  DashboardTimelineResponse,
  DashboardWidget,
  DashboardWidgetsResponse,
  DashboardWorkspace,
  DashboardWorkspaceKey,
} from '../types/dashboard';

function queryString(filters: DashboardFilters = {}) {
  const search = new URLSearchParams();

  Object.entries(filters).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== '') {
      search.set(key, String(value));
    }
  });

  const value = search.toString();

  return value ? `?${value}` : '';
}

export const dashboardService = {
  home(filters: DashboardFilters) {
    return apiClient<DashboardHome>(`/dashboard${queryString(filters)}`);
  },

  workspace(workspace: DashboardWorkspaceKey, filters: DashboardFilters) {
    return apiClient<DashboardWorkspace>(`/dashboard/${workspace}${queryString(filters)}`);
  },

  kpi(filters: DashboardFilters) {
    return apiClient<DashboardKpiResponse>(`/dashboard/kpi${queryString(filters)}`);
  },

  widgets(filters: DashboardFilters) {
    return apiClient<DashboardWidgetsResponse>(`/dashboard/widgets${queryString(filters)}`);
  },

  widgetDetail(widgetKey: string) {
    return apiClient<DashboardWidget>(`/dashboard/widgets/${widgetKey}`);
  },

  refreshWidget(widgetKey: string, filters: DashboardFilters) {
    return apiClient<DashboardWidget>(`/dashboard/widgets/${widgetKey}/refresh`, {
      method: 'POST',
      body: JSON.stringify(filters),
    });
  },

  alerts(filters: DashboardFilters) {
    return apiClient<DashboardAlertsResponse>(`/dashboard/alerts${queryString(filters)}`);
  },

  timeline(filters: DashboardFilters) {
    return apiClient<DashboardTimelineResponse>(`/dashboard/timeline${queryString(filters)}`);
  },

  analytics(filters: DashboardFilters) {
    return apiClient<DashboardAnalyticsResponse>(`/dashboard/analytics${queryString(filters)}`);
  },

  refresh(filters: DashboardFilters) {
    return apiClient<DashboardRefreshResult>('/dashboard/refresh', {
      method: 'POST',
      body: JSON.stringify(filters),
    });
  },

  cacheStatus() {
    return apiClient<DashboardCacheStatus>('/dashboard/cache/status');
  },

  statistics() {
    return apiClient<DashboardStatistics>('/dashboard/statistics');
  },

  exportDashboard(filters: DashboardFilters & { format: DashboardExportResult['format'] }) {
    return apiClient<DashboardExportResult>(`/dashboard/export${queryString(filters)}`);
  },
};

export type DashboardResponse<T> = ApiSuccessResponse<T>;
