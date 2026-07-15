import { Bell, Database, Server, TimerReset } from 'lucide-react';
import { EmptyState, LoadingBlock } from './DashboardStates';
import type { DashboardAlertsResponse, DashboardCacheStatus, DashboardStatistics } from '../types/dashboard';

type NotificationPanelProps = {
  alerts?: DashboardAlertsResponse;
  cache?: DashboardCacheStatus;
  loading: boolean;
  statistics?: DashboardStatistics;
};

export function NotificationPanel({ alerts, cache, loading, statistics }: NotificationPanelProps) {
  if (loading) {
    return <LoadingBlock />;
  }

  const entries = [
    {
      icon: Bell,
      label: 'Notifications',
      value: `${alerts?.items.length ?? 0} active`,
    },
    {
      icon: TimerReset,
      label: 'Reminders',
      value: 'No pending reminder',
    },
    {
      icon: Server,
      label: 'System Message',
      value: `${statistics?.active_widget ?? 0} active widgets`,
    },
    {
      icon: Database,
      label: 'Cache',
      value: cache?.enabled ? `${cache.tracked_keys} tracked keys` : 'Unavailable',
    },
  ];

  return (
    <aside className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center justify-between gap-3">
        <div>
          <h2 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Notification Panel</h2>
          <p className="text-xs text-slate-500 dark:text-slate-400">Alerts, reminders, and system status</p>
        </div>
        <Bell aria-hidden="true" className="h-5 w-5 text-brand" />
      </div>
      <div className="mt-4 space-y-3">
        {entries.length > 0 ? (
          entries.map((entry) => (
            <article className="flex items-start gap-3 rounded-md border border-slate-200 p-3 dark:border-slate-800" key={entry.label}>
              <span className="flex h-8 w-8 shrink-0 items-center justify-center rounded-md bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
                <entry.icon aria-hidden="true" className="h-4 w-4" />
              </span>
              <div className="min-w-0">
                <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">{entry.label}</h3>
                <p className="break-words text-sm text-slate-600 dark:text-slate-300">{entry.value}</p>
              </div>
            </article>
          ))
        ) : (
          <EmptyState />
        )}
      </div>
    </aside>
  );
}
