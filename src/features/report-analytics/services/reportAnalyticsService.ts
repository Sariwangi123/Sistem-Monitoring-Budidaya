import { apiClient } from '../../../services/apiClient';
import type {
  ReportCategoryKey,
  ReportCategoryResponse,
  ReportExportMetadata,
  ReportFilters,
  ReportGeneratedResponse,
  ReportGeneratePayload,
  ReportRegistryDetailResponse,
  ReportRegistryResponse,
  ReportScheduleDeleteResponse,
  ReportScheduleItem,
  ReportSchedulePayload,
  ReportSchedulesResponse,
} from '../types/reportAnalytics';

function queryString(filters: ReportFilters = {}) {
  const search = new URLSearchParams();

  Object.entries(filters).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== '') {
      search.set(key, String(value));
    }
  });

  const value = search.toString();

  return value ? `?${value}` : '';
}

export const reportAnalyticsService = {
  registry(filters: ReportFilters) {
    return apiClient<ReportRegistryResponse>(`/reports/report-registry${queryString(filters)}`);
  },

  registryDetail(reportId: string) {
    return apiClient<ReportRegistryDetailResponse>(`/reports/report-registry/${reportId}`);
  },

  category(category: ReportCategoryKey, filters: ReportFilters) {
    const endpoint = category === 'financial' ? 'finance' : category;

    return apiClient<ReportCategoryResponse>(`/reports/${endpoint}${queryString(filters)}`);
  },

  generate(payload: ReportGeneratePayload) {
    return apiClient<ReportGeneratedResponse>('/reports/generate', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  },

  exportMetadata(reportId: string, format: 'pdf' | 'xlsx' | 'csv' | 'json') {
    return apiClient<ReportExportMetadata>(`/reports/export/${reportId}?format=${format}`);
  },

  schedules(filters: ReportFilters) {
    return apiClient<ReportSchedulesResponse>(`/reports/schedules${queryString(filters)}`);
  },

  createSchedule(payload: ReportSchedulePayload) {
    return apiClient<ReportScheduleItem>('/reports/schedules', {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  },

  deleteSchedule(uuid: string) {
    return apiClient<ReportScheduleDeleteResponse>(`/reports/schedules/${uuid}`, {
      method: 'DELETE',
    });
  },
};
