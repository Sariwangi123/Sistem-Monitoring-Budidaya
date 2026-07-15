import { useEffect, useMemo, useState } from 'react';
import { RefreshCw, ShieldCheck } from 'lucide-react';
import { Breadcrumb } from '../components/Breadcrumb';
import { AlertCenter } from '../features/dashboard/components/AlertCenter';
import { DashboardFilterBar } from '../features/dashboard/components/DashboardFilterBar';
import { ErrorState } from '../features/dashboard/components/DashboardStates';
import { KpiBar } from '../features/dashboard/components/KpiBar';
import { NotificationPanel } from '../features/dashboard/components/NotificationPanel';
import { OperationalIntelligencePanel } from '../features/dashboard/components/OperationalIntelligencePanel';
import { TimelinePanel } from '../features/dashboard/components/TimelinePanel';
import { WidgetGrid } from '../features/dashboard/components/WidgetGrid';
import { WorkspaceSelector } from '../features/dashboard/components/WorkspaceSelector';
import { workspaceOptions } from '../features/dashboard/components/dashboardConfig';
import {
  useDashboardAlerts,
  useDashboardCacheStatus,
  useDashboardHome,
  useDashboardIntelligence,
  useDashboardKpi,
  useDashboardStatistics,
  useDashboardTimeline,
  useDashboardWorkspace,
  useExportDashboard,
  useRefreshDashboard,
  useRefreshDashboardWidget,
} from '../features/dashboard/hooks/useDashboard';
import type { DashboardFilters, DashboardWorkspaceKey } from '../features/dashboard/types/dashboard';
import { useAuthStore } from '../stores/authStore';

function allowedWorkspaces(roleSlugs: string[]): DashboardWorkspaceKey[] {
  const workspaces = workspaceOptions
    .filter((workspace) => workspace.roles.some((role) => roleSlugs.includes(role)))
    .map((workspace) => workspace.key);

  return workspaces.length > 0 ? workspaces : ['executive'];
}

export function DashboardPage() {
  const roles = useAuthStore((state) => state.session?.user.roles ?? []);
  const roleSlugs = useMemo(() => roles.map((role) => role.slug), [roles]);
  const availableWorkspaces = useMemo(() => allowedWorkspaces(roleSlugs), [roleSlugs]);
  const [activeWorkspace, setActiveWorkspace] = useState<DashboardWorkspaceKey>(availableWorkspaces[0] ?? 'executive');
  const [filters, setFilters] = useState<DashboardFilters>({ workspace: activeWorkspace });
  const [refreshingWidgetKey, setRefreshingWidgetKey] = useState<string>();
  const [lastUpdated, setLastUpdated] = useState<Date | null>(null);
  const [statusMessage, setStatusMessage] = useState<string>('Dashboard ready.');
  const activeFilters = useMemo(
    () => ({ ...filters, workspace: activeWorkspace }),
    [activeWorkspace, filters],
  );

  const homeQuery = useDashboardHome(activeFilters);
  const workspaceQuery = useDashboardWorkspace(activeWorkspace, activeFilters);
  const kpiQuery = useDashboardKpi(activeFilters);
  const intelligenceQuery = useDashboardIntelligence(activeFilters);
  const alertsQuery = useDashboardAlerts(activeFilters);
  const timelineQuery = useDashboardTimeline(activeFilters);
  const cacheQuery = useDashboardCacheStatus();
  const statisticsQuery = useDashboardStatistics();
  const refreshDashboard = useRefreshDashboard();
  const refreshWidget = useRefreshDashboardWidget();
  const exportDashboard = useExportDashboard();

  useEffect(() => {
    if (!availableWorkspaces.includes(activeWorkspace)) {
      const nextWorkspace = availableWorkspaces[0] ?? 'executive';
      setActiveWorkspace(nextWorkspace);
      setFilters((current) => ({ ...current, workspace: nextWorkspace }));
    }
  }, [activeWorkspace, availableWorkspaces]);

  useEffect(() => {
    if (
      workspaceQuery.isSuccess ||
      kpiQuery.isSuccess ||
      intelligenceQuery.isSuccess ||
      alertsQuery.isSuccess ||
      timelineQuery.isSuccess ||
      homeQuery.isSuccess
    ) {
      setLastUpdated(new Date());
    }
  }, [
    alertsQuery.isSuccess,
    homeQuery.isSuccess,
    intelligenceQuery.isSuccess,
    kpiQuery.isSuccess,
    timelineQuery.isSuccess,
    workspaceQuery.isSuccess,
  ]);

  const workspaceWidgets = workspaceQuery.data?.data.widgets ?? homeQuery.data?.data.widgets ?? [];
  const hasPageError = workspaceQuery.isError && kpiQuery.isError;

  function handleWorkspaceChange(workspace: DashboardWorkspaceKey) {
    setActiveWorkspace(workspace);
    setFilters((current) => ({ ...current, workspace }));
  }

  function handleRefreshDashboard() {
    refreshDashboard.mutate(activeFilters, {
      onSuccess: () => {
        setLastUpdated(new Date());
        setStatusMessage('Dashboard refreshed.');
      },
      onError: (error) => setStatusMessage(error.message),
    });
  }

  function handleRefreshWidget(widgetKey: string) {
    setRefreshingWidgetKey(widgetKey);
    refreshWidget.mutate(
      { widgetKey, filters: activeFilters },
      {
        onSettled: () => setRefreshingWidgetKey(undefined),
        onSuccess: () => {
          setLastUpdated(new Date());
          setStatusMessage('Widget refreshed.');
        },
        onError: (error) => setStatusMessage(error.message),
      },
    );
  }

  function handleExportWidget() {
    exportDashboard.mutate(
      { ...activeFilters, format: 'csv' },
      {
        onSuccess: (response) => setStatusMessage(`Export ${response.data.format.toUpperCase()} ${response.data.status}.`),
        onError: (error) => setStatusMessage(error.message),
      },
    );
  }

  return (
    <div className="space-y-5">
      <div className="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div className="space-y-2">
          <Breadcrumb items={['UtiFarm', 'Dashboard']} />
          <div>
            <h1 className="text-2xl font-semibold text-slate-950 dark:text-slate-50">Operational Command Center</h1>
            <p className="mt-1 max-w-3xl text-sm text-slate-600 dark:text-slate-300">
              Read-only monitoring workspace for production, inventory, harvest, finance, and system operations.
            </p>
          </div>
        </div>
        <div className="flex flex-wrap items-center gap-2">
          <span className="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200">
            <ShieldCheck aria-hidden="true" className="h-4 w-4 text-brand" />
            Read Only
          </span>
          <button
            aria-label="Refresh dashboard manually"
            className="inline-flex items-center gap-2 rounded-md bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 dark:focus:ring-offset-slate-950"
            disabled={refreshDashboard.isPending}
            onClick={handleRefreshDashboard}
            type="button"
          >
            <RefreshCw aria-hidden="true" className={refreshDashboard.isPending ? 'h-4 w-4 animate-spin' : 'h-4 w-4'} />
            Refresh
          </button>
        </div>
      </div>

      <WorkspaceSelector
        activeWorkspace={activeWorkspace}
        allowedWorkspaces={availableWorkspaces}
        onChange={handleWorkspaceChange}
      />

      <DashboardFilterBar
        filters={activeFilters}
        lastUpdated={lastUpdated}
        onChange={(nextFilters) => setFilters({ ...nextFilters, workspace: activeWorkspace })}
        onRefresh={handleRefreshDashboard}
        refreshing={refreshDashboard.isPending}
      />

      <div aria-live="polite" className="rounded-md border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
        {statusMessage}
      </div>

      {hasPageError ? <ErrorState message="Dashboard data could not be loaded." /> : null}

      <KpiBar items={kpiQuery.data?.data.items} loading={kpiQuery.isLoading} />

      <OperationalIntelligencePanel data={intelligenceQuery.data?.data} loading={intelligenceQuery.isLoading} />

      <WidgetGrid
        lastUpdated={lastUpdated}
        onExportWidget={handleExportWidget}
        onRefreshWidget={handleRefreshWidget}
        refreshingWidgetKey={refreshingWidgetKey}
        widgets={workspaceWidgets}
        workspace={activeWorkspace}
      />

      <div className="grid gap-4 xl:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)]">
        <TimelinePanel data={timelineQuery.data?.data} loading={timelineQuery.isLoading} />
        <NotificationPanel
          alerts={alertsQuery.data?.data}
          cache={cacheQuery.data?.data}
          loading={alertsQuery.isLoading || cacheQuery.isLoading || statisticsQuery.isLoading}
          statistics={statisticsQuery.data?.data}
        />
      </div>

      <AlertCenter data={alertsQuery.data?.data} loading={alertsQuery.isLoading} />

      <footer className="flex flex-wrap items-center justify-between gap-3 rounded-md border border-slate-200 bg-white px-4 py-3 text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
        <span>Workspace: {activeWorkspace}</span>
        <span>Cache: {String(kpiQuery.data?.meta?.cache_status ?? workspaceQuery.data?.meta?.cache_status ?? 'waiting')}</span>
        <span>Last updated: {lastUpdated ? lastUpdated.toLocaleString('id-ID') : 'Waiting for data'}</span>
      </footer>
    </div>
  );
}
