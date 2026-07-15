import { RefreshCw, Search } from 'lucide-react';
import type { DashboardFilters } from '../types/dashboard';

type DashboardFilterBarProps = {
  filters: DashboardFilters;
  lastUpdated: Date | null;
  refreshing: boolean;
  onChange: (filters: DashboardFilters) => void;
  onRefresh: () => void;
};

export function DashboardFilterBar({ filters, lastUpdated, refreshing, onChange, onRefresh }: DashboardFilterBarProps) {
  return (
    <section className="rounded-md border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="grid gap-3 lg:grid-cols-[minmax(180px,1fr)_130px_130px_130px_130px_130px_auto]">
        <label className="flex items-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-sm dark:border-slate-700">
          <Search aria-hidden="true" className="h-4 w-4 text-slate-400" />
          <input
            aria-label="Search dashboard"
            className="w-full bg-transparent text-sm outline-none placeholder:text-slate-400 dark:text-slate-100"
            onChange={(event) => onChange({ ...filters, search: event.target.value })}
            placeholder="Search farm, pond, cycle"
            type="search"
            value={filters.search ?? ''}
          />
        </label>
        <input
          aria-label="Farm filter"
          className="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          onChange={(event) => onChange({ ...filters, farm_id: event.target.value })}
          placeholder="Farm ID"
          value={filters.farm_id ?? ''}
        />
        <input
          aria-label="Culture cycle filter"
          className="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          onChange={(event) => onChange({ ...filters, culture_cycle_id: event.target.value })}
          placeholder="Cycle ID"
          value={filters.culture_cycle_id ?? ''}
        />
        <input
          aria-label="Pond filter"
          className="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          onChange={(event) => onChange({ ...filters, pond_id: event.target.value })}
          placeholder="Pond ID"
          value={filters.pond_id ?? ''}
        />
        <input
          aria-label="Financial period filter"
          className="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          onChange={(event) => onChange({ ...filters, financial_period_id: event.target.value })}
          placeholder="Period ID"
          value={filters.financial_period_id ?? ''}
        />
        <input
          aria-label="Date range filter"
          className="rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
          onChange={(event) => onChange({ ...filters, date_range: event.target.value })}
          placeholder="Date range"
          value={filters.date_range ?? ''}
        />
        <button
          aria-label="Refresh dashboard"
          className="inline-flex items-center justify-center gap-2 rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-200 dark:focus:ring-offset-slate-950"
          disabled={refreshing}
          onClick={onRefresh}
          type="button"
        >
          <RefreshCw aria-hidden="true" className={refreshing ? 'h-4 w-4 animate-spin' : 'h-4 w-4'} />
          Refresh
        </button>
      </div>
      <p className="mt-3 text-xs text-slate-500 dark:text-slate-400">
        Last updated: {lastUpdated ? lastUpdated.toLocaleString('id-ID') : 'Waiting for data'}
      </p>
    </section>
  );
}
