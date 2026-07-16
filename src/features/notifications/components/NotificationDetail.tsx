import { Archive, Check, ExternalLink, RotateCw, Trash2, type LucideIcon } from 'lucide-react';
import { label, priorityClasses, statusClasses } from './notificationConfig';
import { NotificationEmptyState, NotificationLoadingState } from './NotificationStates';
import type { NotificationItem } from '../types/notification';

type NotificationDetailProps = {
  item?: NotificationItem;
  loading: boolean;
  actionPending: boolean;
  onRead: (id: string) => void;
  onArchive: (id: string) => void;
  onDelete: (id: string) => void;
  onRetry: (id: string) => void;
};

function displayDate(value: string | null) {
  return value ? new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium', timeStyle: 'short' }).format(new Date(value)) : 'Not available';
}

export function NotificationDetail({ item, loading, actionPending, onRead, onArchive, onDelete, onRetry }: NotificationDetailProps) {
  if (loading) return <NotificationLoadingState />;
  if (!item) return <NotificationEmptyState message="Select a notification" />;

  const canRead = item.status === 'delivered' || item.status === 'sent';
  const canArchive = item.status === 'read';

  return (
    <section aria-label="Notification detail" className="space-y-5 p-4">
      <div className="space-y-3">
        <div className="flex flex-wrap items-center gap-2 text-xs">
          <span className={`rounded-full border px-2 py-1 font-semibold ${priorityClasses[item.priority] ?? priorityClasses.information}`}>{label(item.priority)}</span>
          <span className={`font-medium ${statusClasses[item.status] ?? 'text-slate-500'}`}>{label(item.status)}</span>
        </div>
        <h2 className="text-lg font-semibold text-slate-950 dark:text-slate-50">{item.title}</h2>
        <p className="whitespace-pre-wrap text-sm leading-6 text-slate-600 dark:text-slate-300">{item.message}</p>
      </div>

      <dl className="grid gap-3 text-sm sm:grid-cols-2">
        {[
          ['Category', label(item.category)],
          ['Source module', item.source_module],
          ['Event', item.event_name],
          ['Delivery status', label(item.status)],
          ['Created', displayDate(item.created_at)],
          ['Read', displayDate(item.read_at)],
        ].map(([term, definition]) => (
          <div key={term}>
            <dt className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">{term}</dt>
            <dd className="mt-1 break-words text-slate-700 dark:text-slate-200">{definition}</dd>
          </div>
        ))}
      </dl>

      {item.metadata && Object.keys(item.metadata).length > 0 ? (
        <div>
          <h3 className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Metadata</h3>
          <pre className="mt-2 max-h-40 overflow-auto rounded-md bg-slate-50 p-3 text-xs text-slate-700 dark:bg-slate-950 dark:text-slate-200">{JSON.stringify(item.metadata, null, 2)}</pre>
        </div>
      ) : null}

      <div className="flex flex-wrap gap-2 border-t border-slate-200 pt-4 dark:border-slate-800">
        {canRead ? <ActionButton disabled={actionPending} icon={Check} label="Mark read" onClick={() => onRead(item.id)} /> : null}
        {canArchive ? <ActionButton disabled={actionPending} icon={Archive} label="Archive" onClick={() => onArchive(item.id)} /> : null}
        {item.status === 'failed' ? <ActionButton disabled={actionPending} icon={RotateCw} label="Retry" onClick={() => onRetry(item.id)} /> : null}
        <ActionButton disabled={actionPending} icon={Trash2} label="Delete" onClick={() => onDelete(item.id)} tone="danger" />
        {item.action_url ? (
          <a className="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800" href={item.action_url} rel="noreferrer" target="_blank">
            <ExternalLink aria-hidden="true" className="h-4 w-4" />
            Open related module
          </a>
        ) : null}
      </div>
    </section>
  );
}

function ActionButton({ disabled, icon: Icon, label, onClick, tone = 'default' }: { disabled: boolean; icon: LucideIcon; label: string; onClick: () => void; tone?: 'default' | 'danger' }) {
  return (
    <button
      className={tone === 'danger' ? 'inline-flex items-center gap-2 rounded-md border border-red-200 px-3 py-2 text-sm font-medium text-red-700 hover:bg-red-50 disabled:opacity-60 dark:border-red-900 dark:text-red-300 dark:hover:bg-red-950' : 'inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 disabled:opacity-60 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800'}
      disabled={disabled}
      onClick={onClick}
      type="button"
    >
      <Icon aria-hidden="true" className="h-4 w-4" />
      {label}
    </button>
  );
}
