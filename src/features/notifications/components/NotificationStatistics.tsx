import { Archive, BellRing, CircleAlert, OctagonAlert, TriangleAlert } from 'lucide-react';
import type { NotificationStatistics as NotificationStatisticsType } from '../types/notification';

type NotificationStatisticsProps = {
  statistics?: NotificationStatisticsType;
  todayTotal: number;
  loading: boolean;
};

export function NotificationStatistics({ statistics, todayTotal, loading }: NotificationStatisticsProps) {
  const items = [
    { label: 'Total', value: statistics?.total_notification ?? 0, icon: BellRing, tone: 'text-sky-700 dark:text-sky-300' },
    { label: 'Unread', value: statistics?.total_unread ?? 0, icon: CircleAlert, tone: 'text-amber-700 dark:text-amber-300' },
    { label: 'Today', value: todayTotal, icon: BellRing, tone: 'text-brand' },
    { label: 'Critical', value: statistics?.by_priority.critical ?? 0, icon: OctagonAlert, tone: 'text-red-700 dark:text-red-300' },
    { label: 'Failed', value: statistics?.by_status.failed ?? 0, icon: TriangleAlert, tone: 'text-red-700 dark:text-red-300' },
    { label: 'Archived', value: statistics?.total_archived ?? 0, icon: Archive, tone: 'text-slate-600 dark:text-slate-300' },
  ];

  return (
    <section aria-label="Notification statistics" className="grid grid-cols-2 gap-2 sm:grid-cols-3 xl:grid-cols-6">
      {items.map((item) => {
        const Icon = item.icon;

        return (
          <div className="rounded-md border border-slate-200 bg-white px-3 py-3 dark:border-slate-800 dark:bg-slate-900" key={item.label}>
            <Icon aria-hidden="true" className={`h-4 w-4 ${item.tone}`} />
            <p className="mt-2 text-lg font-semibold text-slate-950 dark:text-slate-50">{loading ? '...' : item.value}</p>
            <p className="text-xs text-slate-500 dark:text-slate-400">{item.label}</p>
          </div>
        );
      })}
    </section>
  );
}
