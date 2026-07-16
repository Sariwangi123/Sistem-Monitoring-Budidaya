import { CheckCircle2, CircleAlert } from 'lucide-react';
import { categoryIcons, label, priorityClasses, statusClasses } from './notificationConfig';
import { NotificationEmptyState, NotificationSkeleton } from './NotificationStates';
import type { NotificationItem } from '../types/notification';

type NotificationListProps = {
  items: NotificationItem[];
  loading: boolean;
  selectedId?: string;
  onSelect: (item: NotificationItem) => void;
};

function relativeTime(value: string | null) {
  if (!value) return 'Unknown time';
  const minutes = Math.floor((Date.now() - new Date(value).getTime()) / 60_000);
  if (minutes < 1) return 'Just now';
  if (minutes < 60) return `${minutes}m ago`;
  if (minutes < 1_440) return `${Math.floor(minutes / 60)}h ago`;
  return new Intl.DateTimeFormat('id-ID', { day: 'numeric', month: 'short' }).format(new Date(value));
}

export function NotificationList({ items, loading, selectedId, onSelect }: NotificationListProps) {
  if (loading) return <NotificationSkeleton />;
  if (items.length === 0) return <NotificationEmptyState />;

  return (
    <section aria-label="Notification list" className="divide-y divide-slate-100 dark:divide-slate-800">
      {items.map((item) => {
        const Icon = categoryIcons[item.category] ?? CircleAlert;
        const selected = item.id === selectedId;
        const unread = item.status !== 'read' && item.status !== 'archived';

        return (
          <button
            aria-pressed={selected}
            className={
              selected
                ? 'w-full border-l-2 border-brand bg-brand-soft px-4 py-3 text-left dark:bg-slate-800'
                : 'w-full border-l-2 border-transparent px-4 py-3 text-left hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand dark:hover:bg-slate-800'
            }
            key={item.id}
            onClick={() => onSelect(item)}
            type="button"
          >
            <span className="flex gap-3">
              <span className="mt-0.5 rounded-md bg-slate-100 p-2 text-brand dark:bg-slate-800">
                <Icon aria-hidden="true" className="h-4 w-4" />
              </span>
              <span className="min-w-0 flex-1">
                <span className="flex items-start justify-between gap-3">
                  <span className="truncate text-sm font-semibold text-slate-900 dark:text-slate-100">{item.title}</span>
                  <span className="shrink-0 text-xs text-slate-500 dark:text-slate-400">{relativeTime(item.created_at)}</span>
                </span>
                <span className="mt-1 block line-clamp-2 text-sm text-slate-600 dark:text-slate-300">{item.message}</span>
                <span className="mt-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs">
                  <span className={`rounded-full border px-2 py-0.5 font-semibold ${priorityClasses[item.priority] ?? priorityClasses.information}`}>{label(item.priority)}</span>
                  <span className="text-slate-500 dark:text-slate-400">{label(item.category)}</span>
                  <span className="text-slate-500 dark:text-slate-400">{item.source_module}</span>
                  <span className={`inline-flex items-center gap-1 ${statusClasses[item.status] ?? 'text-slate-500'}`}>
                    {item.status === 'read' ? <CheckCircle2 aria-hidden="true" className="h-3.5 w-3.5" /> : null}
                    {label(item.status)}
                  </span>
                  {unread ? <span className="h-2 w-2 rounded-full bg-brand" title="Unread" /> : null}
                </span>
              </span>
            </span>
          </button>
        );
      })}
    </section>
  );
}
