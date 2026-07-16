import { lazy, Suspense, useEffect, useState } from 'react';
import { AppLayout } from './layouts/AppLayout';

const DashboardPage = lazy(() => import('./pages/DashboardPage').then((module) => ({ default: module.DashboardPage })));
const ReportAnalyticsPage = lazy(() => import('./pages/ReportAnalyticsPage').then((module) => ({ default: module.ReportAnalyticsPage })));
const NotificationCenterPage = lazy(() => import('./pages/NotificationCenterPage').then((module) => ({ default: module.NotificationCenterPage })));
const AdministrationPage = lazy(() => import('./pages/AdministrationPage').then((module) => ({ default: module.AdministrationPage })));

export type AppPage = 'dashboard' | 'reports' | 'notifications' | 'administration';

function currentPageFromHash(): AppPage {
  if (window.location.hash === '#/reports') return 'reports';
  if (window.location.hash === '#/notifications') return 'notifications';
  if (window.location.hash === '#/administration') return 'administration';
  return 'dashboard';
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
    window.location.hash = page === 'reports' ? '#/reports' : page === 'notifications' ? '#/notifications' : page === 'administration' ? '#/administration' : '#/dashboard';
    setCurrentPage(page);
  }

  return (
    <AppLayout currentPage={currentPage} onNavigate={handleNavigate}>
      <Suspense fallback={<div className="h-40 animate-pulse rounded-md border border-slate-200 bg-white" />}>
        {currentPage === 'reports' ? <ReportAnalyticsPage /> : currentPage === 'notifications' ? <NotificationCenterPage /> : currentPage === 'administration' ? <AdministrationPage /> : <DashboardPage />}
      </Suspense>
    </AppLayout>
  );
}
