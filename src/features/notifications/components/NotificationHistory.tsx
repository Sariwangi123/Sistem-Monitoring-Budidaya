import { History } from 'lucide-react';
import type { NotificationHistoryItem } from '../types/notification';

export function NotificationHistory({ items }: { items: NotificationHistoryItem[] }) {
  return (
    <section aria-labelledby="notification-history-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <History aria-hidden="true" className="h-4 w-4 text-brand" />
        <h2 id="notification-history-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Recent history</h2>
      </div>
      <div className="mt-3 space-y-3">
        {items.slice(0, 5).map((item) => (
          <div className="border-l-2 border-slate-200 pl-3 text-xs dark:border-slate-700" key={item.id}>
            <p className="font-semibold text-slate-700 dark:text-slate-200">{item.event_name}</p>
            <p className="mt-1 text-slate-500 dark:text-slate-400">{item.status} via {item.channel} · attempt {item.attempt}</p>
          </div>
        ))}
        {items.length === 0 ? <p className="text-sm text-slate-500 dark:text-slate-400">No history available.</p> : null}
      </div>
    </section>
  );
}
