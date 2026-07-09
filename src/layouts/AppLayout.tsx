import type { ReactNode } from 'react';
import { Navbar } from '../components/Navbar';
import { Sidebar } from '../components/Sidebar';

type AppLayoutProps = {
  children: ReactNode;
};

export function AppLayout({ children }: AppLayoutProps) {
  return (
    <div className="min-h-screen bg-slate-50 text-slate-900">
      <Sidebar />
      <div className="min-h-screen lg:pl-64">
        <Navbar />
        <main className="px-4 py-6 sm:px-6 lg:px-8">{children}</main>
      </div>
    </div>
  );
}
