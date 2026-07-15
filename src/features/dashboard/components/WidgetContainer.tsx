import { ChevronDown, Download, Maximize2, RefreshCw } from 'lucide-react';
import { EmptyState } from './DashboardStates';
import type { WidgetBlueprint } from './dashboardConfig';
import type { DashboardWidget } from '../types/dashboard';

type WidgetContainerProps = {
  blueprint: WidgetBlueprint;
  widget?: DashboardWidget;
  refreshing: boolean;
  lastUpdated: Date | null;
  onExport: (widgetKey: string) => void;
  onRefresh: (widgetKey: string) => void;
};

const sizeClass: Record<DashboardWidget['size'], string> = {
  XS: 'md:col-span-3 xl:col-span-2',
  Small: 'md:col-span-3 xl:col-span-3',
  Medium: 'md:col-span-3 xl:col-span-4',
  Large: 'md:col-span-6 xl:col-span-6',
  'Full Width': 'md:col-span-6 xl:col-span-12',
};

export function WidgetContainer({ blueprint, widget, refreshing, lastUpdated, onExport, onRefresh }: WidgetContainerProps) {
  const Icon = blueprint.icon;
  const state = widget?.status ?? 'Empty';
  const hasData = widget?.data && (Array.isArray(widget.data) ? widget.data.length > 0 : Object.keys(widget.data).length > 0);

  return (
    <section
      aria-label={blueprint.title}
      className={`min-h-56 rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 ${sizeClass[blueprint.size]}`}
    >
      <div className="flex items-start justify-between gap-3">
        <div className="flex min-w-0 items-center gap-3">
          <span className="flex h-9 w-9 shrink-0 items-center justify-center rounded-md bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200">
            <Icon aria-hidden="true" className="h-5 w-5" />
          </span>
          <div className="min-w-0">
            <h2 className="truncate text-sm font-semibold text-slate-950 dark:text-slate-50">{blueprint.title}</h2>
            <p className="text-xs text-slate-500 dark:text-slate-400">{blueprint.category}</p>
          </div>
        </div>
        <div className="flex items-center gap-1">
          <button
            aria-label={`Refresh ${blueprint.title}`}
            className="rounded-md p-2 text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-300 dark:hover:bg-slate-800"
            disabled={refreshing}
            onClick={() => onRefresh(blueprint.key)}
            title="Refresh"
            type="button"
          >
            <RefreshCw aria-hidden="true" className={refreshing ? 'h-4 w-4 animate-spin' : 'h-4 w-4'} />
          </button>
          <button
            aria-label={`Export ${blueprint.title}`}
            className="rounded-md p-2 text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-300 dark:hover:bg-slate-800"
            onClick={() => onExport(blueprint.key)}
            title="Export"
            type="button"
          >
            <Download aria-hidden="true" className="h-4 w-4" />
          </button>
          <button
            aria-label={`Expand ${blueprint.title}`}
            className="rounded-md p-2 text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-300 dark:hover:bg-slate-800"
            title="Expand"
            type="button"
          >
            <Maximize2 aria-hidden="true" className="h-4 w-4" />
          </button>
          <button
            aria-label={`Collapse ${blueprint.title}`}
            className="rounded-md p-2 text-slate-500 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-300 dark:hover:bg-slate-800"
            title="Collapse"
            type="button"
          >
            <ChevronDown aria-hidden="true" className="h-4 w-4" />
          </button>
        </div>
      </div>
      <div className="mt-4">
        {state === 'Error' ? (
          <div className="rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
            {widget?.error ?? 'Widget data could not be loaded.'}
          </div>
        ) : hasData ? (
          <pre className="max-h-36 overflow-auto rounded-md bg-slate-950 p-3 text-xs text-slate-100">
            {JSON.stringify(widget?.data, null, 2)}
          </pre>
        ) : (
          <EmptyState onRefresh={() => onRefresh(blueprint.key)} refreshing={refreshing} />
        )}
      </div>
      <div className="mt-4 flex flex-wrap items-center justify-between gap-2 text-xs text-slate-500 dark:text-slate-400">
        <span>Status: {state}</span>
        <span>{lastUpdated ? lastUpdated.toLocaleTimeString('id-ID') : 'Waiting'}</span>
      </div>
    </section>
  );
}
