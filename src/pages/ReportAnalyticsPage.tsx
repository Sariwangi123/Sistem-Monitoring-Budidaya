import { useEffect, useMemo, useState } from 'react';
import { FileText, RefreshCw, ShieldCheck } from 'lucide-react';
import { Breadcrumb } from '../components/Breadcrumb';
import { BusinessIntelligencePanel } from '../features/report-analytics/components/BusinessIntelligencePanel';
import { ReportExportPanel } from '../features/report-analytics/components/ReportExportPanel';
import { ReportFilterPanel } from '../features/report-analytics/components/ReportFilterPanel';
import { ReportList } from '../features/report-analytics/components/ReportList';
import { ReportNavigation } from '../features/report-analytics/components/ReportNavigation';
import { ReportPreviewPanel } from '../features/report-analytics/components/ReportPreviewPanel';
import { ReportEmptyState, ReportErrorState, ReportLoadingState } from '../features/report-analytics/components/ReportStates';
import { ScheduledReportPanel } from '../features/report-analytics/components/ScheduledReportPanel';
import {
  useCreateReportSchedule,
  useDeleteReportSchedule,
  useBenchmarkAnalysis,
  useDecisionSupportInsights,
  useExecutiveScorecard,
  useExportReportMetadata,
  useGenerateReport,
  useKpiAnalytics,
  useReportCategory,
  useReportRegistry,
  useReportSchedules,
  useTrendAnalysis,
} from '../features/report-analytics/hooks/useReportAnalytics';
import type {
  ReportCategoryKey,
  ReportDefinition,
  ReportFilters,
  ReportScheduleItem,
} from '../features/report-analytics/types/reportAnalytics';

const SESSION_FILTER_KEY = 'utifarm.report.filters';

function initialFilters(): ReportFilters {
  const stored = window.sessionStorage.getItem(SESSION_FILTER_KEY);

  if (!stored) {
    return { period: 'monthly' };
  }

  try {
    return JSON.parse(stored) as ReportFilters;
  } catch {
    return { period: 'monthly' };
  }
}

export function ReportAnalyticsPage() {
  const [activeCategory, setActiveCategory] = useState<ReportCategoryKey>('executive');
  const [filters, setFilters] = useState<ReportFilters>(() => initialFilters());
  const [selectedReport, setSelectedReport] = useState<ReportDefinition>();
  const [createdSchedules, setCreatedSchedules] = useState<ReportScheduleItem[]>([]);
  const [lastGeneratedAt, setLastGeneratedAt] = useState<Date | null>(null);
  const [statusMessage, setStatusMessage] = useState('Report workspace ready.');

  const activeFilters = useMemo(
    () => ({ ...filters, report_category: activeCategory }),
    [activeCategory, filters],
  );

  const registryQuery = useReportRegistry(activeFilters);
  const categoryQuery = useReportCategory(activeCategory, activeFilters);
  const schedulesQuery = useReportSchedules(activeFilters);
  const scorecardQuery = useExecutiveScorecard(activeFilters);
  const trendQuery = useTrendAnalysis(activeFilters);
  const kpiQuery = useKpiAnalytics(activeFilters);
  const benchmarkQuery = useBenchmarkAnalysis(activeFilters);
  const insightsQuery = useDecisionSupportInsights(activeFilters);
  const generateReport = useGenerateReport();
  const exportMetadata = useExportReportMetadata();
  const createSchedule = useCreateReportSchedule();
  const deleteSchedule = useDeleteReportSchedule();

  const reports = useMemo(() => {
    const categoryReports = categoryQuery.data?.data.reports ?? [];
    const registryReports = registryQuery.data?.data.items ?? [];
    const source = categoryReports.length > 0 ? categoryReports : registryReports;
    const search = (filters.search ?? '').toLowerCase();

    return source.filter((report) => {
      if (report.category !== activeCategory) {
        return false;
      }

      if (!search) {
        return true;
      }

      return report.name.toLowerCase().includes(search)
        || report.category.toLowerCase().includes(search)
        || report.source_module.toLowerCase().includes(search);
    });
  }, [activeCategory, categoryQuery.data?.data.reports, filters.search, registryQuery.data?.data.items]);

  const schedules = useMemo(
    () => [...createdSchedules, ...(schedulesQuery.data?.data.items ?? [])],
    [createdSchedules, schedulesQuery.data?.data.items],
  );

  useEffect(() => {
    window.sessionStorage.setItem(SESSION_FILTER_KEY, JSON.stringify(filters));
  }, [filters]);

  useEffect(() => {
    if (reports.length > 0 && (!selectedReport || selectedReport.category !== activeCategory)) {
      setSelectedReport(reports[0]);
    }
  }, [activeCategory, reports, selectedReport]);

  function handleCategoryChange(category: ReportCategoryKey) {
    setActiveCategory(category);
    setSelectedReport(undefined);
    setStatusMessage(`${category} reports selected.`);
  }

  function handleGenerate(format: 'pdf' | 'xlsx' | 'csv' | 'json') {
    if (!selectedReport) {
      return;
    }

    generateReport.mutate(
      {
        report_type: selectedReport.id,
        template: selectedReport.template,
        export_format: format,
        locale: 'id',
        filter: activeFilters,
        parameter: { preview: true },
      },
      {
        onSuccess: (response) => {
          setLastGeneratedAt(new Date());
          setStatusMessage(`Preview generated: ${response.data.export.file_name}`);
        },
        onError: (error) => setStatusMessage(error.message),
      },
    );
  }

  function handleExport(format: 'pdf' | 'xlsx' | 'csv') {
    if (!selectedReport) {
      return;
    }

    exportMetadata.mutate(
      { reportId: selectedReport.id, format },
      {
        onSuccess: (response) => {
          setStatusMessage(`${response.data.format.toUpperCase()} export adapter ready.`);
        },
        onError: (error) => setStatusMessage(error.message),
      },
    );
  }

  function handleCreateSchedule(frequency: 'daily' | 'weekly' | 'monthly' | 'quarterly' | 'yearly', format: 'pdf' | 'xlsx' | 'csv' | 'json') {
    if (!selectedReport) {
      return;
    }

    createSchedule.mutate(
      {
        report_id: selectedReport.id,
        frequency,
        export_format: format,
        timezone: 'Asia/Jakarta',
        filters: activeFilters,
      },
      {
        onSuccess: (response) => {
          setCreatedSchedules((current) => [response.data, ...current]);
          setStatusMessage('Scheduled report foundation accepted.');
        },
        onError: (error) => setStatusMessage(error.message),
      },
    );
  }

  function handleDeleteSchedule(uuid: string) {
    deleteSchedule.mutate(uuid, {
      onSuccess: () => {
        setCreatedSchedules((current) => current.filter((schedule) => schedule.uuid !== uuid));
        setStatusMessage('Scheduled report foundation deleted.');
      },
      onError: (error) => setStatusMessage(error.message),
    });
  }

  const hasError = registryQuery.isError || categoryQuery.isError;

  return (
    <div className="space-y-5">
      <div className="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div className="space-y-2">
          <Breadcrumb items={['UtiFarm', 'Report Analytics']} />
          <div>
            <h1 className="text-2xl font-semibold text-slate-950 dark:text-slate-50">Report Workspace</h1>
            <p className="mt-1 max-w-3xl text-sm text-slate-600 dark:text-slate-300">
              Read-only workspace for report search, preview, export metadata, and scheduled report foundation.
            </p>
          </div>
        </div>
        <div className="flex flex-wrap items-center gap-2">
          <span className="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200">
            <ShieldCheck aria-hidden="true" className="h-4 w-4 text-brand" />
            Generate, Never Store
          </span>
          <button
            aria-label="Refresh reports"
            className="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800"
            onClick={() => {
              void registryQuery.refetch();
              void categoryQuery.refetch();
              void schedulesQuery.refetch();
              void scorecardQuery.refetch();
              void trendQuery.refetch();
              void kpiQuery.refetch();
              void benchmarkQuery.refetch();
              void insightsQuery.refetch();
              setStatusMessage('Report workspace refreshed.');
            }}
            type="button"
          >
            <RefreshCw aria-hidden="true" className="h-4 w-4" />
            Refresh
          </button>
        </div>
      </div>

      <div aria-live="polite" className="rounded-md border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
        {statusMessage}
      </div>

      {hasError ? <ReportErrorState message="Report workspace data could not be loaded." /> : null}

      <BusinessIntelligencePanel
        benchmark={benchmarkQuery.data?.data}
        insights={insightsQuery.data?.data}
        kpi={kpiQuery.data?.data}
        loading={scorecardQuery.isLoading || trendQuery.isLoading || kpiQuery.isLoading}
        scorecard={scorecardQuery.data?.data}
        trend={trendQuery.data?.data}
      />

      <div className="grid gap-4 xl:grid-cols-[240px_minmax(0,340px)_minmax(0,1fr)]">
        <div className="space-y-4">
          <ReportNavigation activeCategory={activeCategory} onChange={handleCategoryChange} />
          <ReportFilterPanel filters={filters} onChange={setFilters} />
        </div>

        <div className="space-y-4">
          {registryQuery.isLoading || categoryQuery.isLoading ? (
            <ReportLoadingState />
          ) : (
            <ReportList reports={reports} selectedReportId={selectedReport?.id} onSelect={setSelectedReport} />
          )}
          <ReportExportPanel
            exportMetadata={exportMetadata.data?.data}
            generated={generateReport.data?.data}
            generating={generateReport.isPending}
            exporting={exportMetadata.isPending}
            onExport={handleExport}
            onGenerate={handleGenerate}
            report={selectedReport}
          />
        </div>

        <div className="space-y-4">
          {reports.length === 0 && !categoryQuery.isLoading ? (
            <ReportEmptyState />
          ) : (
            <ReportPreviewPanel
              categoryData={categoryQuery.data?.data}
              generated={generateReport.data?.data}
              lastGeneratedAt={lastGeneratedAt}
              report={selectedReport}
            />
          )}
          <ScheduledReportPanel
            creating={createSchedule.isPending}
            deleting={deleteSchedule.isPending}
            filters={activeFilters}
            onCreate={handleCreateSchedule}
            onDelete={handleDeleteSchedule}
            report={selectedReport}
            schedules={schedules}
          />
        </div>
      </div>

      <footer className="flex flex-wrap items-center justify-between gap-3 rounded-md border border-slate-200 bg-white px-4 py-3 text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
        <span>Category: {activeCategory}</span>
        <span>Reports: {reports.length}</span>
        <span className="inline-flex items-center gap-1">
          <FileText aria-hidden="true" className="h-3.5 w-3.5" />
          Last generated: {lastGeneratedAt ? lastGeneratedAt.toLocaleString('id-ID') : 'Waiting for preview'}
        </span>
      </footer>
    </div>
  );
}
