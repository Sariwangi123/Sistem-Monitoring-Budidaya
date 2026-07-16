import { BarChart3, Bell, Database, FileText, Settings, Shield, Users } from 'lucide-react';
import type { AppPage } from '../App';

const items = [
  { label: 'Dashboard', icon: BarChart3, page: 'dashboard' as AppPage },
  { label: 'Report Analytics', icon: FileText, page: 'reports' as AppPage },
  { label: 'Users', icon: Users },
  { label: 'Roles', icon: Shield },
  { label: 'Settings', icon: Settings },
  { label: 'Notifications', icon: Bell, page: 'notifications' as AppPage },
  { label: 'Administration', icon: Settings, page: 'administration' as AppPage },
  { label: 'Master Data', icon: Database },
];

type SidebarProps = {
  currentPage: AppPage;
  onNavigate: (page: AppPage) => void;
};

export function Sidebar({ currentPage, onNavigate }: SidebarProps) {
  return (
    <aside className="hidden h-screen w-64 border-r border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:flex lg:flex-col">
      <div className="border-b border-slate-200 px-6 py-5">
        <p className="text-lg font-semibold text-brand-dark">UtiFarm</p>
      </div>
      <nav className="flex-1 space-y-1 px-3 py-4">
        {items.map((item) => (
          <button
            aria-current={item.page === currentPage ? 'page' : undefined}
            key={item.label}
            className={
              item.page === currentPage
                ? 'flex w-full items-center gap-3 rounded-md bg-brand-soft px-3 py-2 text-left text-sm font-semibold text-brand-dark'
                : 'flex w-full items-center gap-3 rounded-md px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-brand-soft hover:text-brand-dark'
            }
            onClick={() => {
              if (item.page) {
                onNavigate(item.page);
              }
            }}
            type="button"
          >
            <item.icon aria-hidden="true" className="h-4 w-4" />
            {item.label}
          </button>
        ))}
      </nav>
    </aside>
  );
}
