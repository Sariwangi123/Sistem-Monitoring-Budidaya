import { Activity, HeartPulse, Lightbulb, Sparkles } from 'lucide-react';
import { EmptyState, LoadingBlock } from './DashboardStates';
import type { DashboardHealthSummary, DashboardIntelligenceResponse } from '../types/dashboard';

type OperationalIntelligencePanelProps = {
  data?: DashboardIntelligenceResponse;
  loading: boolean;
};

const toneClass = {
  neutral: 'border-slate-200 bg-white text-slate-800 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-200',
  good: 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-100',
  warning: 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-100',
  danger: 'border-red-200 bg-red-50 text-red-900 dark:border-red-900 dark:bg-red-950 dark:text-red-100',
};

function healthCards(data: DashboardIntelligenceResponse): DashboardHealthSummary[] {
  return [
    data.farm_health_summary,
    data.pond_health_summary,
    data.financial_health_summary,
    data.inventory_health_summary,
    data.production_health_summary,
  ];
}

export function OperationalIntelligencePanel({ data, loading }: OperationalIntelligencePanelProps) {
  if (loading) {
    return <LoadingBlock />;
  }

  if (!data) {
    return <EmptyState />;
  }

  return (
    <section className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex flex-wrap items-start justify-between gap-3">
        <div>
          <div className="flex items-center gap-2">
            <Sparkles aria-hidden="true" className="h-5 w-5 text-brand" />
            <h2 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Operational Intelligence</h2>
          </div>
          <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">
            Rule-based insight from existing business modules.
          </p>
        </div>
        <span className="rounded-md border border-slate-200 px-2 py-1 text-xs font-semibold text-slate-600 dark:border-slate-700 dark:text-slate-300">
          {data.meta.mode}
        </span>
      </div>

      <div className="mt-4 grid gap-3 md:grid-cols-2 xl:grid-cols-5">
        {healthCards(data).map((item) => (
          <article className="rounded-md border border-slate-200 p-3 dark:border-slate-800" key={item.label}>
            <div className="flex items-center gap-2">
              <HeartPulse aria-hidden="true" className="h-4 w-4 text-brand" />
              <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">{item.label}</h3>
            </div>
            <p className="mt-2 text-2xl font-semibold text-slate-950 dark:text-slate-50">{item.score}</p>
            <p className="text-xs text-slate-500 dark:text-slate-400">{item.status} · {item.source}</p>
          </article>
        ))}
      </div>

      <div className="mt-4 grid gap-4 xl:grid-cols-2">
        <div className="space-y-3">
          <div className="flex items-center gap-2">
            <Activity aria-hidden="true" className="h-4 w-4 text-brand" />
            <h3 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Insight Cards</h3>
          </div>
          {data.insight_cards.length > 0 ? (
            data.insight_cards.map((insight) => (
              <article className={`rounded-md border p-3 ${toneClass[insight.tone]}`} key={insight.key}>
                <h4 className="text-sm font-semibold">{insight.title}</h4>
                <p className="mt-1 text-sm">{insight.description}</p>
              </article>
            ))
          ) : (
            <EmptyState />
          )}
        </div>

        <div className="space-y-3">
          <div className="flex items-center gap-2">
            <Lightbulb aria-hidden="true" className="h-4 w-4 text-brand" />
            <h3 className="text-sm font-semibold text-slate-950 dark:text-slate-50">Recommendation Panel</h3>
          </div>
          {data.recommendations.length > 0 ? (
            data.recommendations.map((recommendation) => (
              <article className="rounded-md border border-slate-200 p-3 dark:border-slate-800" key={recommendation.key}>
                <div className="flex flex-wrap items-start justify-between gap-2">
                  <h4 className="text-sm font-semibold text-slate-900 dark:text-slate-100">{recommendation.title}</h4>
                  <span className="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                    {recommendation.priority}
                  </span>
                </div>
                <p className="mt-1 text-sm text-slate-600 dark:text-slate-300">{recommendation.description}</p>
                <p className="mt-2 text-xs font-semibold text-slate-500 dark:text-slate-400">{recommendation.action}</p>
              </article>
            ))
          ) : (
            <EmptyState />
          )}
        </div>
      </div>
    </section>
  );
}
