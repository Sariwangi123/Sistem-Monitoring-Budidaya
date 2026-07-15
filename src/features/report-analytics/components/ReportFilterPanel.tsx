import { Filter, Search } from 'lucide-react';
import type { ReportFilters } from '../types/reportAnalytics';

type ReportFilterPanelProps = {
  filters: ReportFilters;
  onChange: (filters: ReportFilters) => void;
};

const fieldLabels: Array<[keyof ReportFilters, string, string]> = [
  ['company_id', 'Company', 'Company ID'],
  ['farm_id', 'Farm', 'Farm ID'],
  ['pond_id', 'Pond', 'Pond ID'],
  ['culture_cycle_id', 'Culture Cycle', 'Cycle ID'],
  ['financial_period_id', 'Financial Period', 'Period ID'],
  ['customer_id', 'Customer', 'Customer ID'],
  ['date_range', 'Date Range', '2026-07-01..2026-07-31'],
  ['period', 'Period', 'monthly'],
];

export function ReportFilterPanel({ filters, onChange }: ReportFilterPanelProps) {
  function update(key: keyof ReportFilters, value: string) {
    onChange({ ...filters, [key]: value });
  }

  return (
    <section aria-labelledby="report-filter-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <Filter aria-hidden="true" className="h-4 w-4 text-brand" />
        <h2 id="report-filter-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Filters</h2>
      </div>
      <label className="mt-4 block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
        Global Search
        <span className="mt-1 flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 dark:border-slate-700">
          <Search aria-hidden="true" className="h-4 w-4 text-slate-400" />
          <input
            aria-label="Search reports"
            className="w-full border-0 bg-transparent text-sm outline-none placeholder:text-slate-400 dark:text-slate-100"
            onChange={(event) => update('search', event.target.value)}
            placeholder="Report, farm, pond, period"
            type="search"
            value={filters.search ?? ''}
          />
        </span>
      </label>
      <div className="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-1">
        {fieldLabels.map(([key, label, placeholder]) => (
          <label className="block text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400" key={key}>
            {label}
            <input
              className="mt-1 w-full rounded-md border border-slate-200 bg-white px-3 py-2 text-sm text-slate-800 outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100"
              onChange={(event) => update(key, event.target.value)}
              placeholder={placeholder}
              type="text"
              value={filters[key] ?? ''}
            />
          </label>
        ))}
      </div>
    </section>
  );
}
