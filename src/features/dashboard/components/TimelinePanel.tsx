import { Clock3 } from 'lucide-react';
import { EmptyState, LoadingBlock } from './DashboardStates';
import type { DashboardTimelineItem, DashboardTimelineResponse } from '../types/dashboard';

type TimelinePanelProps = {
  data?: DashboardTimelineResponse;
  loading: boolean;
};

function timelineItems(data?: DashboardTimelineResponse): DashboardTimelineItem[] {
  return [
    ...(data?.recent_activities ?? []),
    ...(data?.harvest_events ?? []),
    ...(data?.inventory_events ?? []),
    ...(data?.financial_events ?? []),
  ];
}

export function TimelinePanel({ data, loading }: TimelinePanelProps) {
  if (loading) {
    return <LoadingBlock />;
  }

  const items = timelineItems(data);

  return (
    <section className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <Clock3 aria-hidden="true" className="h-5 w-5 text-brand" />
        <h2 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Timeline</h2>
      </div>
      <div className="mt-4 space-y-3">
        {items.length > 0 ? (
          items.map((item, index) => (
            <article className="border-l-2 border-brand pl-3" key={`${item.id ?? item.title ?? 'timeline'}-${index}`}>
              <h3 className="text-sm font-semibold text-slate-800 dark:text-slate-100">{item.title ?? item.type ?? 'Activity'}</h3>
              <p className="text-sm text-slate-600 dark:text-slate-300">{item.description ?? 'No details available'}</p>
              <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">{item.occurred_at ?? 'Recent'}</p>
            </article>
          ))
        ) : (
          <EmptyState />
        )}
      </div>
    </section>
  );
}
