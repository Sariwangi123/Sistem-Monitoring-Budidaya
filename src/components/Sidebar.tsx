import { BarChart3, Bell, Database, Settings, Shield, Users } from 'lucide-react';

const items = [
  { label: 'Dashboard', icon: BarChart3 },
  { label: 'Users', icon: Users },
  { label: 'Roles', icon: Shield },
  { label: 'Settings', icon: Settings },
  { label: 'Notifications', icon: Bell },
  { label: 'Master Data', icon: Database },
];

export function Sidebar() {
  return (
    <aside className="hidden h-screen w-64 border-r border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:flex lg:flex-col">
      <div className="border-b border-slate-200 px-6 py-5">
        <p className="text-lg font-semibold text-brand-dark">UtiFarm</p>
      </div>
      <nav className="flex-1 space-y-1 px-3 py-4">
        {items.map((item) => (
          <button
            key={item.label}
            className="flex w-full items-center gap-3 rounded-md px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-brand-soft hover:text-brand-dark"
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
