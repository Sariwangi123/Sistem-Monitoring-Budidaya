import type { ReactNode } from 'react';
import type { AppPage } from '../App';
import { Navbar } from '../components/Navbar';
import { Sidebar } from '../components/Sidebar';

type AppLayoutProps = {
  children: ReactNode;
  currentPage: AppPage;
  onNavigate: (page: AppPage) => void;
};

export function AppLayout({ children, currentPage, onNavigate }: AppLayoutProps) {
  return (
    <div className="min-h-screen bg-slate-50 text-slate-900">
      <Sidebar currentPage={currentPage} onNavigate={onNavigate} />
      <div className="min-h-screen lg:pl-64">
        <Navbar />
        <main className="px-4 py-6 sm:px-6 lg:px-8">{children}</main>
      </div>
    </div>
  );
}
