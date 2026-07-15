import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { reportAnalyticsService } from '../services/reportAnalyticsService';
import type {
  ReportCategoryKey,
  ReportFilters,
  ReportGeneratePayload,
  ReportSchedulePayload,
} from '../types/reportAnalytics';

const reportKeys = {
  all: ['report-analytics'] as const,
  registry: (filters: ReportFilters) => [...reportKeys.all, 'registry', filters] as const,
  registryDetail: (reportId: string) => [...reportKeys.all, 'registry-detail', reportId] as const,
  category: (category: ReportCategoryKey, filters: ReportFilters) =>
    [...reportKeys.all, 'category', category, filters] as const,
  schedules: (filters: ReportFilters) => [...reportKeys.all, 'schedules', filters] as const,
  bi: (scope: string, filters: ReportFilters) => [...reportKeys.all, 'bi', scope, filters] as const,
};

export function useReportRegistry(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.registry(filters),
    queryFn: () => reportAnalyticsService.registry(filters),
    staleTime: 30_000,
  });
}

export function useReportRegistryDetail(reportId: string) {
  return useQuery({
    enabled: reportId.length > 0,
    queryKey: reportKeys.registryDetail(reportId),
    queryFn: () => reportAnalyticsService.registryDetail(reportId),
    staleTime: 30_000,
  });
}

export function useReportCategory(category: ReportCategoryKey, filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.category(category, filters),
    queryFn: () => reportAnalyticsService.category(category, filters),
    staleTime: 30_000,
  });
}

export function useReportSchedules(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.schedules(filters),
    queryFn: () => reportAnalyticsService.schedules(filters),
    staleTime: 30_000,
  });
}

export function useGenerateReport() {
  return useMutation({
    mutationFn: (payload: ReportGeneratePayload) => reportAnalyticsService.generate(payload),
  });
}

export function useExportReportMetadata() {
  return useMutation({
    mutationFn: ({ reportId, format }: { reportId: string; format: 'pdf' | 'xlsx' | 'csv' | 'json' }) =>
      reportAnalyticsService.exportMetadata(reportId, format),
  });
}

export function useCreateReportSchedule() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (payload: ReportSchedulePayload) => reportAnalyticsService.createSchedule(payload),
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: reportKeys.all });
    },
  });
}

export function useDeleteReportSchedule() {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn: (uuid: string) => reportAnalyticsService.deleteSchedule(uuid),
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: reportKeys.all });
    },
  });
}

export function useExecutiveScorecard(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.bi('executive-scorecard', filters),
    queryFn: () => reportAnalyticsService.executiveScorecard(filters),
    staleTime: 60_000,
  });
}

export function useTrendAnalysis(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.bi('trend-analysis', filters),
    queryFn: () => reportAnalyticsService.trendAnalysis(filters),
    staleTime: 60_000,
  });
}

export function useKpiAnalytics(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.bi('kpi-analytics', filters),
    queryFn: () => reportAnalyticsService.kpiAnalytics(filters),
    staleTime: 60_000,
  });
}

export function useBenchmarkAnalysis(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.bi('benchmark-analysis', filters),
    queryFn: () => reportAnalyticsService.benchmarkAnalysis(filters),
    staleTime: 60_000,
  });
}

export function useDecisionSupportInsights(filters: ReportFilters) {
  return useQuery({
    queryKey: reportKeys.bi('decision-support-insights', filters),
    queryFn: () => reportAnalyticsService.decisionSupportInsights(filters),
    staleTime: 60_000,
  });
}
