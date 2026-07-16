import { Bell, Search, UserCircle } from 'lucide-react';
import type { AppPage } from '../App';
import { useNotificationStatistics } from '../features/notifications/hooks/useNotifications';

type NavbarProps = {
  currentPage: AppPage;
  onNavigate: (page: AppPage) => void;
};

export function Navbar({ currentPage, onNavigate }: NavbarProps) {
  const statisticsQuery = useNotificationStatistics();
  const unreadCount = statisticsQuery.data?.data.total_unread ?? 0;
  const criticalCount = statisticsQuery.data?.data.by_priority.critical ?? 0;

  return (
    <header className="sticky top-0 z-10 border-b border-slate-200 bg-white">
      <div className="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div className="flex min-w-0 flex-1 items-center gap-3">
          <Search aria-hidden="true" className="h-4 w-4 text-slate-400" />
          <input
            className="w-full max-w-md border-0 bg-transparent text-sm outline-none placeholder:text-slate-400"
            placeholder="Search records"
            type="search"
          />
        </div>
        <div className="flex items-center gap-2">
          <button aria-current={currentPage === 'notifications' ? 'page' : undefined} aria-label={`Notifications${unreadCount > 0 ? `, ${unreadCount} unread` : ''}${criticalCount > 0 ? `, ${criticalCount} critical` : ''}`} className="relative rounded-md p-2 text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800" onClick={() => onNavigate('notifications')} title={`Notifications: ${unreadCount} unread, ${criticalCount} critical`} type="button">
            <Bell aria-hidden="true" className="h-5 w-5" />
            {unreadCount > 0 ? <span className="absolute -right-1 -top-1 min-w-4 rounded-full bg-red-600 px-1 text-center text-[10px] font-semibold leading-4 text-white">{unreadCount > 99 ? '99+' : unreadCount}</span> : null}
            {criticalCount > 0 ? <span aria-hidden="true" className="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-amber-500 dark:border-slate-900" /> : null}
          </button>
          <button className="rounded-md p-2 text-slate-600 hover:bg-slate-100" title="Account" type="button">
            <UserCircle aria-hidden="true" className="h-5 w-5" />
          </button>
        </div>
      </div>
    </header>
  );
}
