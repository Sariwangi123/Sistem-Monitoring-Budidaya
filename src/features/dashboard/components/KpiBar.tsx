import { ArrowUpRight, Minus } from 'lucide-react';
import { kpiFallback } from './dashboardConfig';
import { EmptyState, LoadingBlock } from './DashboardStates';
import type { DashboardKpiItem } from '../types/dashboard';

type KpiBarProps = {
  items?: DashboardKpiItem[];
  loading: boolean;
};

const toneClass = {
  neutral: 'border-slate-200 bg-white text-slate-900 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-100',
  good: 'border-emerald-200 bg-emerald-50 text-emerald-950 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-100',
  warning: 'border-amber-200 bg-amber-50 text-amber-950 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-100',
  danger: 'border-red-200 bg-red-50 text-red-950 dark:border-red-900 dark:bg-red-950 dark:text-red-100',
};

export function KpiBar({ items, loading }: KpiBarProps) {
  if (loading) {
    return (
      <div className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8">
        {kpiFallback.map((item) => (
          <LoadingBlock key={item.key} />
        ))}
      </div>
    );
  }

  const kpiItems = items && items.length > 0 ? items : kpiFallback;

  return (
    <section aria-label="KPI bar" className="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-8">
      {kpiItems.map((item) => (
        <article
          className={`min-h-28 rounded-md border p-4 shadow-sm ${toneClass[item.tone ?? 'neutral']}`}
          key={item.key}
        >
          <div className="flex items-start justify-between gap-2">
            <p className="text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">{item.label}</p>
            {item.trend ? (
              <ArrowUpRight aria-hidden="true" className="h-4 w-4 text-emerald-600" />
            ) : (
              <Minus aria-hidden="true" className="h-4 w-4 text-slate-400" />
            )}
          </div>
          <p className="mt-3 break-words text-xl font-semibold">{item.value}</p>
          <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">{item.trend ?? 'No trend'}</p>
        </article>
      ))}
      {kpiItems.length === 0 ? <EmptyState /> : null}
    </section>
  );
}
