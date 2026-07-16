import { BellOff, Loader2, TriangleAlert } from 'lucide-react';

export function NotificationSkeleton() {
  return (
    <div aria-label="Loading notifications" className="space-y-2 p-4">
      {[1, 2, 3, 4, 5].map((item) => (
        <div className="animate-pulse rounded-md border border-slate-200 p-3 dark:border-slate-800" key={item}>
          <div className="h-4 w-3/4 rounded bg-slate-200 dark:bg-slate-800" />
          <div className="mt-2 h-3 w-full rounded bg-slate-100 dark:bg-slate-800" />
        </div>
      ))}
    </div>
  );
}

export function NotificationLoadingState() {
  return (
    <div className="flex min-h-32 items-center justify-center rounded-md border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
      <Loader2 aria-hidden="true" className="h-5 w-5 animate-spin text-brand" />
    </div>
  );
}

export function NotificationErrorState({ message }: { message: string }) {
  return (
    <div role="alert" className="flex min-h-28 items-center gap-3 rounded-md border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
      <TriangleAlert aria-hidden="true" className="h-5 w-5 shrink-0" />
      <span>{message}</span>
    </div>
  );
}

export function NotificationEmptyState({ message = 'No Notification' }: { message?: string }) {
  return (
    <div className="flex min-h-48 flex-col items-center justify-center gap-2 p-5 text-center">
      <BellOff aria-hidden="true" className="h-6 w-6 text-slate-400" />
      <p className="text-sm font-semibold text-slate-700 dark:text-slate-200">{message}</p>
      <p className="text-xs text-slate-500 dark:text-slate-400">Semua notifikasi telah ditangani.</p>
    </div>
  );
}
