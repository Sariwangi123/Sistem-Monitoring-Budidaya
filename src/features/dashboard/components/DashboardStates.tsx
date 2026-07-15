import { AlertCircle, Loader2, RefreshCw } from 'lucide-react';

type EmptyStateProps = {
  onRefresh?: () => void;
  refreshing?: boolean;
};

export function LoadingBlock() {
  return (
    <div className="flex min-h-36 items-center justify-center rounded-md border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
      <Loader2 aria-hidden="true" className="h-5 w-5 animate-spin text-brand" />
    </div>
  );
}

export function ErrorState({ message }: { message: string }) {
  return (
    <div className="flex min-h-36 items-center gap-3 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
      <AlertCircle aria-hidden="true" className="h-5 w-5 shrink-0" />
      <span>{message}</span>
    </div>
  );
}

export function EmptyState({ onRefresh, refreshing = false }: EmptyStateProps) {
  return (
    <div className="flex min-h-28 flex-col items-center justify-center gap-3 rounded-md border border-dashed border-slate-300 bg-slate-50 p-4 text-center dark:border-slate-700 dark:bg-slate-950">
      <AlertCircle aria-hidden="true" className="h-5 w-5 text-slate-400" />
      <p className="text-sm font-medium text-slate-600 dark:text-slate-300">No Data Available</p>
      {onRefresh ? (
        <button
          aria-label="Refresh widget"
          className="inline-flex items-center gap-2 rounded-md border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-white focus:outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-900"
          disabled={refreshing}
          onClick={onRefresh}
          type="button"
        >
          <RefreshCw aria-hidden="true" className={refreshing ? 'h-4 w-4 animate-spin' : 'h-4 w-4'} />
          Refresh
        </button>
      ) : null}
    </div>
  );
}
