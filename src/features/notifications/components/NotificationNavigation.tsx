import { Archive } from 'lucide-react';
import { notificationViews, type NotificationView } from './notificationConfig';

type NotificationNavigationProps = {
  activeView: NotificationView;
  unreadCount: number;
  onChange: (view: NotificationView) => void;
};

export function NotificationNavigation({ activeView, unreadCount, onChange }: NotificationNavigationProps) {
  return (
    <nav aria-label="Notification workspace" className="border-b border-slate-200 p-3 dark:border-slate-800 lg:border-b-0 lg:border-r">
      <div className="flex gap-2 overflow-x-auto lg:flex-col">
        {notificationViews.map((view) => {
          const Icon = view.key === 'archive' ? Archive : view.icon;
          const active = activeView === view.key;

          return (
            <button
              aria-current={active ? 'page' : undefined}
              className={
                active
                  ? 'flex shrink-0 items-center gap-2 rounded-md bg-brand-soft px-3 py-2 text-left text-sm font-semibold text-brand-dark dark:bg-slate-800 dark:text-brand'
                  : 'flex shrink-0 items-center gap-2 rounded-md px-3 py-2 text-left text-sm font-medium text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800'
              }
              key={view.key}
              onClick={() => onChange(view.key)}
              type="button"
            >
              <Icon aria-hidden="true" className="h-4 w-4" />
              <span className="whitespace-nowrap">{view.label}</span>
              {view.key === 'unread' && unreadCount > 0 ? (
                <span className="ml-auto rounded-full bg-brand px-2 py-0.5 text-xs text-white">{unreadCount}</span>
              ) : null}
            </button>
          );
        })}
      </div>
    </nav>
  );
}
