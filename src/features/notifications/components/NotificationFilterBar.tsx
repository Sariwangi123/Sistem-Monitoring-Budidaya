import { ArrowDownUp, Filter, Search, X } from 'lucide-react';
import { categories, label, priorities, statuses } from './notificationConfig';
import type { NotificationFilters } from '../types/notification';

type NotificationFilterBarProps = {
  filters: NotificationFilters;
  onChange: (filters: NotificationFilters) => void;
  onClear: () => void;
};

export function NotificationFilterBar({ filters, onChange, onClear }: NotificationFilterBarProps) {
  function update(key: keyof NotificationFilters, value: string | boolean | number | undefined) {
    onChange({ ...filters, [key]: value || undefined, page: 1 });
  }

  return (
    <section aria-label="Notification search and filters" className="border-b border-slate-200 p-4 dark:border-slate-800">
      <div className="flex flex-col gap-3">
        <label className="flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 dark:border-slate-700">
          <Search aria-hidden="true" className="h-4 w-4 text-slate-400" />
          <input
            aria-label="Search notifications"
            className="min-w-0 flex-1 border-0 bg-transparent text-sm outline-none placeholder:text-slate-400 dark:text-slate-100"
            onChange={(event) => update('search', event.target.value)}
            placeholder="Search title, message, event, source"
            type="search"
            value={filters.search ?? ''}
          />
        </label>
        <div className="grid gap-2 sm:grid-cols-2 xl:grid-cols-3">
          <label className="sr-only" htmlFor="notification-status">Status</label>
          <select id="notification-status" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('status', event.target.value)} value={filters.status ?? ''}>
            <option value="">All statuses</option>
            {statuses.map((status) => <option key={status} value={status}>{label(status)}</option>)}
          </select>
          <label className="sr-only" htmlFor="notification-category">Category</label>
          <select id="notification-category" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('category', event.target.value)} value={filters.category ?? ''}>
            <option value="">All categories</option>
            {categories.map((category) => <option key={category} value={category}>{label(category)}</option>)}
          </select>
          <label className="sr-only" htmlFor="notification-priority">Priority</label>
          <select id="notification-priority" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('priority', event.target.value)} value={filters.priority ?? ''}>
            <option value="">All priorities</option>
            {priorities.map((priority) => <option key={priority} value={priority}>{label(priority)}</option>)}
          </select>
          <input aria-label="Source module" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm placeholder:text-slate-400 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('source_module', event.target.value)} placeholder="Source module" type="text" value={filters.source_module ?? ''} />
          <input aria-label="Start date" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('date_from', event.target.value)} type="date" value={filters.date_from ?? ''} />
          <input aria-label="End date" className="rounded-md border border-slate-200 bg-white px-3 py-2 text-sm dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100" onChange={(event) => update('date_to', event.target.value)} type="date" value={filters.date_to ?? ''} />
        </div>
        <div className="flex flex-wrap items-center gap-2">
          <label className="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300">
            <input checked={filters.unread_only ?? false} className="h-4 w-4 rounded border-slate-300 text-brand focus:ring-brand" onChange={(event) => update('unread_only', event.target.checked)} type="checkbox" />
            Unread only
          </label>
          <button className="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800" onClick={() => update('direction', filters.direction === 'asc' ? 'desc' : 'asc')} type="button">
            <ArrowDownUp aria-hidden="true" className="h-4 w-4" />
            {filters.direction === 'asc' ? 'Oldest' : 'Newest'}
          </button>
          <button className="inline-flex items-center gap-2 rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800" onClick={onClear} type="button">
            <X aria-hidden="true" className="h-4 w-4" />
            Clear
          </button>
          <Filter aria-hidden="true" className="ml-auto h-4 w-4 text-slate-400" />
        </div>
      </div>
    </section>
  );
}
