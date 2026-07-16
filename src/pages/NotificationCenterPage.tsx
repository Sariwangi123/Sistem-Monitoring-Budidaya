import { useEffect, useMemo, useState } from 'react';
import { Archive, CheckCheck, RefreshCw, ShieldCheck } from 'lucide-react';
import { Breadcrumb } from '../components/Breadcrumb';
import { NotificationDetail } from '../features/notifications/components/NotificationDetail';
import { NotificationFilterBar } from '../features/notifications/components/NotificationFilterBar';
import { NotificationHistory } from '../features/notifications/components/NotificationHistory';
import { NotificationList } from '../features/notifications/components/NotificationList';
import { NotificationNavigation } from '../features/notifications/components/NotificationNavigation';
import { NotificationPreferences } from '../features/notifications/components/NotificationPreferences';
import { NotificationErrorState } from '../features/notifications/components/NotificationStates';
import { NotificationStatistics } from '../features/notifications/components/NotificationStatistics';
import { type NotificationView } from '../features/notifications/components/notificationConfig';
import {
  useArchiveAllNotifications,
  useArchiveNotification,
  useDeleteNotification,
  useMarkAllNotificationsRead,
  useMarkNotificationRead,
  useNotificationDetail,
  useNotificationHistory,
  useNotificationPreferences,
  useNotificationStatistics,
  useNotifications,
  useRetryNotification,
  useUpdateNotificationPreferences,
} from '../features/notifications/hooks/useNotifications';
import type { NotificationFilters, NotificationItem } from '../features/notifications/types/notification';

const FILTER_SESSION_KEY = 'utifarm.notification.filters';

function initialFilters(): NotificationFilters {
  try {
    const stored = window.sessionStorage.getItem(FILTER_SESSION_KEY);
    return stored ? { per_page: 15, sort: 'created_at', direction: 'desc', ...JSON.parse(stored) as NotificationFilters } : { per_page: 15, sort: 'created_at', direction: 'desc' };
  } catch {
    return { per_page: 15, sort: 'created_at', direction: 'desc' };
  }
}

function viewFilters(view: NotificationView): NotificationFilters {
  if (view === 'unread') return { unread_only: true };
  if (view === 'critical') return { priority: 'critical' };
  if (view === 'archive') return { status: 'archived' };
  if (view !== 'all') return { category: view };
  return {};
}

export function NotificationCenterPage() {
  const [activeView, setActiveView] = useState<NotificationView>('all');
  const [filters, setFilters] = useState<NotificationFilters>(() => initialFilters());
  const [selectedItem, setSelectedItem] = useState<NotificationItem>();
  const [statusMessage, setStatusMessage] = useState('Notification Center ready.');

  const activeFilters = useMemo(() => ({ ...filters, ...viewFilters(activeView) }), [activeView, filters]);
  const today = new Intl.DateTimeFormat('en-CA', { timeZone: 'Asia/Jakarta' }).format(new Date());
  const listQuery = useNotifications(activeFilters);
  const detailQuery = useNotificationDetail(selectedItem?.id);
  const statisticsQuery = useNotificationStatistics(activeFilters);
  const todayStatisticsQuery = useNotificationStatistics({ date_from: today, date_to: today });
  const historyQuery = useNotificationHistory({ per_page: 5, sort: 'created_at', direction: 'desc' });
  const preferencesQuery = useNotificationPreferences();
  const markRead = useMarkNotificationRead();
  const markAllRead = useMarkAllNotificationsRead();
  const archive = useArchiveNotification();
  const archiveAll = useArchiveAllNotifications();
  const remove = useDeleteNotification();
  const retry = useRetryNotification();
  const updatePreferences = useUpdateNotificationPreferences();

  const items = listQuery.data?.data ?? [];
  const selected = detailQuery.data?.data ?? selectedItem;
  const actionPending = markRead.isPending || markAllRead.isPending || archive.isPending || archiveAll.isPending || remove.isPending || retry.isPending;

  useEffect(() => {
    window.sessionStorage.setItem(FILTER_SESSION_KEY, JSON.stringify(filters));
  }, [filters]);

  useEffect(() => {
    if (selectedItem && !items.some((item) => item.id === selectedItem.id)) {
      setSelectedItem(undefined);
    }
  }, [items, selectedItem]);

  function select(item: NotificationItem) {
    setSelectedItem(item);
  }

  function runAction(action: () => void, message: string) {
    action();
    setStatusMessage(message);
  }

  function resetFilters() {
    setActiveView('all');
    setFilters({ per_page: 15, sort: 'created_at', direction: 'desc' });
  }

  return (
    <div className="space-y-5">
      <div className="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div className="space-y-2">
          <Breadcrumb items={['UtiFarm', 'Notifications']} />
          <div>
            <h1 className="text-2xl font-semibold text-slate-950 dark:text-slate-50">Notification Center</h1>
            <p className="mt-1 max-w-3xl text-sm text-slate-600 dark:text-slate-300">User-scoped operational communications, reminders, and system alerts.</p>
          </div>
        </div>
        <div className="flex flex-wrap items-center gap-2">
          <span className="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200">
            <ShieldCheck aria-hidden="true" className="h-4 w-4 text-brand" />
            User scoped
          </span>
          <button aria-label="Refresh notification center" className="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800" onClick={() => { void listQuery.refetch(); void statisticsQuery.refetch(); void historyQuery.refetch(); setStatusMessage('Notification Center refreshed.'); }} type="button">
            <RefreshCw aria-hidden="true" className="h-4 w-4" />
            Refresh
          </button>
          <button className="inline-flex items-center gap-2 rounded-md bg-brand px-3 py-2 text-sm font-semibold text-white hover:bg-brand-dark disabled:opacity-60" disabled={actionPending} onClick={() => markAllRead.mutate(undefined, { onSuccess: (response) => setStatusMessage(`${response.data.updated_count ?? 0} notifications marked as read.`), onError: (error) => setStatusMessage(error.message) })} type="button">
            <CheckCheck aria-hidden="true" className="h-4 w-4" />
            Mark all read
          </button>
          <button className="inline-flex items-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-60 dark:border-slate-800 dark:text-slate-200 dark:hover:bg-slate-800" disabled={actionPending} onClick={() => archiveAll.mutate(undefined, { onSuccess: (response) => setStatusMessage(`${response.data.updated_count ?? 0} notifications archived.`), onError: (error) => setStatusMessage(error.message) })} type="button">
            <Archive aria-hidden="true" className="h-4 w-4" />
            Archive read
          </button>
        </div>
      </div>

      <NotificationStatistics loading={statisticsQuery.isLoading || todayStatisticsQuery.isLoading} statistics={statisticsQuery.data?.data} todayTotal={todayStatisticsQuery.data?.data.total_notification ?? 0} />

      <div aria-live="polite" className="rounded-md border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 shadow-sm dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">{statusMessage}</div>

      {listQuery.isError ? <NotificationErrorState message="Notifications could not be loaded." /> : null}

      <div className="overflow-hidden rounded-md border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div className="grid lg:grid-cols-[220px_minmax(0,1fr)] 2xl:grid-cols-[220px_minmax(360px,0.8fr)_minmax(360px,1fr)]">
          <NotificationNavigation activeView={activeView} onChange={setActiveView} unreadCount={statisticsQuery.data?.data.total_unread ?? 0} />
          <div className="min-w-0 border-b border-slate-200 dark:border-slate-800 2xl:border-b-0 2xl:border-r">
            <NotificationFilterBar filters={filters} onChange={setFilters} onClear={resetFilters} />
            <NotificationList items={items} loading={listQuery.isLoading} onSelect={select} selectedId={selectedItem?.id} />
            <Pagination current={listQuery.data?.pagination.current_page ?? 1} last={listQuery.data?.pagination.last_page ?? 1} onChange={(page) => setFilters((current) => ({ ...current, page }))} total={listQuery.data?.pagination.total ?? 0} />
          </div>
          <div className="min-w-0">
            <NotificationDetail
              actionPending={actionPending}
              item={selected}
              loading={detailQuery.isLoading}
              onArchive={(id) => runAction(() => archive.mutate(id, { onSuccess: () => setStatusMessage('Notification archived.'), onError: (error) => setStatusMessage(error.message) }), 'Archiving notification...')}
              onDelete={(id) => runAction(() => remove.mutate(id, { onSuccess: () => { setSelectedItem(undefined); setStatusMessage('Notification deleted.'); }, onError: (error) => setStatusMessage(error.message) }), 'Deleting notification...')}
              onRead={(id) => runAction(() => markRead.mutate(id, { onSuccess: () => setStatusMessage('Notification marked as read.'), onError: (error) => setStatusMessage(error.message) }), 'Marking notification as read...')}
              onRetry={(id) => runAction(() => retry.mutate(id, { onSuccess: () => setStatusMessage('Notification retry requested.'), onError: (error) => setStatusMessage(error.message) }), 'Requesting retry...')}
            />
          </div>
        </div>
      </div>

      <div className="grid gap-4 xl:grid-cols-2">
        <NotificationHistory items={historyQuery.data?.data ?? []} />
        <NotificationPreferences
          onChange={(payload) => updatePreferences.mutate(payload, { onSuccess: () => setStatusMessage('Notification preferences saved.'), onError: (error) => setStatusMessage(error.message) })}
          preference={preferencesQuery.data?.data}
          saving={updatePreferences.isPending}
        />
      </div>
    </div>
  );
}

function Pagination({ current, last, onChange, total }: { current: number; last: number; onChange: (page: number) => void; total: number }) {
  return (
    <div className="flex items-center justify-between gap-3 border-t border-slate-200 px-4 py-3 text-sm dark:border-slate-800">
      <span className="text-slate-500 dark:text-slate-400">{total} notifications</span>
      <span className="flex items-center gap-2">
        <button className="rounded-md border border-slate-200 px-3 py-1.5 font-medium text-slate-700 disabled:opacity-50 dark:border-slate-700 dark:text-slate-200" disabled={current <= 1} onClick={() => onChange(current - 1)} type="button">Previous</button>
        <span className="text-slate-500 dark:text-slate-400">{current} / {last}</span>
        <button className="rounded-md border border-slate-200 px-3 py-1.5 font-medium text-slate-700 disabled:opacity-50 dark:border-slate-700 dark:text-slate-200" disabled={current >= last} onClick={() => onChange(current + 1)} type="button">Next</button>
      </span>
    </div>
  );
}
