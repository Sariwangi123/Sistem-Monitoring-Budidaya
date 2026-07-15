import { AlertTriangle, Info, ShieldAlert } from 'lucide-react';
import { EmptyState, LoadingBlock } from './DashboardStates';
import type { DashboardAlert, DashboardAlertsResponse } from '../types/dashboard';

type AlertCenterProps = {
  data?: DashboardAlertsResponse;
  loading: boolean;
};

const severityClass: Record<string, string> = {
  Critical: 'border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-200',
  High: 'border-red-200 bg-red-50 text-red-800 dark:border-red-900 dark:bg-red-950 dark:text-red-200',
  Warning: 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-200',
  Medium: 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-200',
  Information: 'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-900 dark:bg-sky-950 dark:text-sky-200',
  Low: 'border-sky-200 bg-sky-50 text-sky-800 dark:border-sky-900 dark:bg-sky-950 dark:text-sky-200',
};

function alertIcon(alert: DashboardAlert) {
  if (alert.severity === 'Critical' || alert.severity === 'High') {
    return ShieldAlert;
  }

  return alert.severity === 'Warning' || alert.severity === 'Medium' ? AlertTriangle : Info;
}

export function AlertCenter({ data, loading }: AlertCenterProps) {
  if (loading) {
    return <LoadingBlock />;
  }

  const alerts = data?.items ?? [];

  return (
    <section className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center justify-between gap-3">
        <div>
          <h2 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Alert Center</h2>
          <p className="text-xs text-slate-500 dark:text-slate-400">Critical, warning, and information alerts</p>
        </div>
        <span className="rounded-md border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 dark:border-slate-700 dark:text-slate-300">
          {alerts.length}
        </span>
      </div>
      <div className="mt-4 space-y-3">
        {alerts.length > 0 ? (
          alerts.map((alert, index) => {
            const Icon = alertIcon(alert);
            const severity = alert.severity ?? 'Information';

            return (
              <article
                className={`rounded-md border p-3 ${severityClass[severity] ?? severityClass.Information}`}
                key={`${alert.id ?? alert.title ?? 'alert'}-${index}`}
              >
                <div className="flex gap-3">
                  <Icon aria-hidden="true" className="mt-0.5 h-4 w-4 shrink-0" />
                  <div className="min-w-0">
                    <h3 className="break-words text-sm font-semibold">{alert.title ?? severity}</h3>
                    <p className="mt-1 break-words text-sm">{alert.message ?? 'No alert details available.'}</p>
                    <p className="mt-2 text-xs opacity-80">{alert.category ?? 'General'} · {alert.status ?? 'Open'}</p>
                  </div>
                </div>
              </article>
            );
          })
        ) : (
          <EmptyState />
        )}
      </div>
    </section>
  );
}
