import { lazy, Suspense, useEffect, useState } from 'react';
import { AppLayout } from './layouts/AppLayout';

const DashboardPage = lazy(() => import('./pages/DashboardPage').then((module) => ({ default: module.DashboardPage })));
const ReportAnalyticsPage = lazy(() => import('./pages/ReportAnalyticsPage').then((module) => ({ default: module.ReportAnalyticsPage })));

export type AppPage = 'dashboard' | 'reports';

function currentPageFromHash(): AppPage {
  return window.location.hash === '#/reports' ? 'reports' : 'dashboard';
}

export function App() {
  const [currentPage, setCurrentPage] = useState<AppPage>(() => currentPageFromHash());

  useEffect(() => {
    function syncHash() {
      setCurrentPage(currentPageFromHash());
    }

    window.addEventListener('hashchange', syncHash);

    return () => window.removeEventListener('hashchange', syncHash);
  }, []);

  function handleNavigate(page: AppPage) {
    window.location.hash = page === 'reports' ? '#/reports' : '#/dashboard';
    setCurrentPage(page);
  }

  return (
    <AppLayout currentPage={currentPage} onNavigate={handleNavigate}>
      <Suspense fallback={<div className="h-40 animate-pulse rounded-md border border-slate-200 bg-white" />}>
        {currentPage === 'reports' ? <ReportAnalyticsPage /> : <DashboardPage />}
      </Suspense>
    </AppLayout>
  );
}
