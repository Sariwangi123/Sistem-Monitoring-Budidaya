import { Bell, Search, UserCircle } from 'lucide-react';

export function Navbar() {
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
          <button className="rounded-md p-2 text-slate-600 hover:bg-slate-100" title="Notifications" type="button">
            <Bell aria-hidden="true" className="h-5 w-5" />
          </button>
          <button className="rounded-md p-2 text-slate-600 hover:bg-slate-100" title="Account" type="button">
            <UserCircle aria-hidden="true" className="h-5 w-5" />
          </button>
        </div>
      </div>
    </header>
  );
}
