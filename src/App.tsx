import { lazy, Suspense } from 'react';
import { AppLayout } from './layouts/AppLayout';

const DashboardPage = lazy(() => import('./pages/DashboardPage').then((module) => ({ default: module.DashboardPage })));

export function App() {
  return (
    <AppLayout>
      <Suspense fallback={<div className="h-40 animate-pulse rounded-md border border-slate-200 bg-white" />}>
        <DashboardPage />
      </Suspense>
    </AppLayout>
  );
}
