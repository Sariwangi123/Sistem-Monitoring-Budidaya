import { Activity, BarChart3, Gauge, Lightbulb, Target } from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type {
  BenchmarkAnalysis,
  DecisionSupportInsights,
  ExecutiveScorecard,
  KpiAnalytics,
  ReportBiEnvelope,
  TrendAnalysis,
} from '../types/reportAnalytics';

type BusinessIntelligencePanelProps = {
  benchmark?: ReportBiEnvelope<BenchmarkAnalysis>;
  insights?: ReportBiEnvelope<DecisionSupportInsights>;
  kpi?: ReportBiEnvelope<KpiAnalytics>;
  loading: boolean;
  scorecard?: ReportBiEnvelope<ExecutiveScorecard>;
  trend?: ReportBiEnvelope<TrendAnalysis>;
};

export function BusinessIntelligencePanel({
  benchmark,
  insights,
  kpi,
  loading,
  scorecard,
  trend,
}: BusinessIntelligencePanelProps) {
  if (loading) {
    return (
      <section className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div className="h-5 w-44 animate-pulse rounded bg-slate-200 dark:bg-slate-800" />
        <div className="mt-4 grid gap-3 md:grid-cols-3">
          {[0, 1, 2].map((item) => (
            <div className="h-24 animate-pulse rounded-md bg-slate-100 dark:bg-slate-800" key={item} />
          ))}
        </div>
      </section>
    );
  }

  return (
    <section className="space-y-4 rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex flex-wrap items-start justify-between gap-3">
        <div>
          <h2 className="text-base font-semibold text-slate-950 dark:text-slate-50">Business Intelligence</h2>
          <p className="mt-1 text-sm text-slate-600 dark:text-slate-300">
            Rule-based executive analytics, read-only, tanpa AI/ML/LLM.
          </p>
        </div>
        <span className="inline-flex items-center gap-2 rounded-md bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
          <Gauge aria-hidden="true" className="h-3.5 w-3.5" />
          Score {scorecard?.data.overall_score ?? '-'}
        </span>
      </div>

      <div className="grid gap-3 md:grid-cols-3">
        <MetricCard icon={Target} label="Executive" value={`${scorecard?.data.overall_score ?? '-'}%`} caption={scorecard?.data.status ?? 'waiting'} />
        <MetricCard icon={Activity} label="Trend" value={trend?.data.series[0]?.direction ?? 'waiting'} caption={trend?.data.period ?? 'monthly'} />
        <MetricCard icon={BarChart3} label="KPI" value={`${kpi?.data.items.length ?? 0}`} caption="validated indicators" />
      </div>

      <div className="grid gap-4 xl:grid-cols-2">
        <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
          <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">Executive Scorecard</h3>
          <div className="mt-3 grid grid-cols-2 gap-2 text-xs text-slate-600 dark:text-slate-300">
            {scorecard
              ? Object.entries({
                  Financial: scorecard.data.financial_score,
                  Production: scorecard.data.production_score,
                  Inventory: scorecard.data.inventory_score,
                  Harvest: scorecard.data.harvest_score,
                  Operational: scorecard.data.operational_score,
                }).map(([label, value]) => (
                  <div className="rounded-md bg-slate-50 px-3 py-2 dark:bg-slate-800" key={label}>
                    <span className="block font-medium">{label}</span>
                    <span className="text-sm font-semibold text-slate-950 dark:text-slate-50">{value}</span>
                  </div>
                ))
              : null}
          </div>
          <p className="mt-3 text-xs text-slate-500 dark:text-slate-400">{scorecard?.data.formula}</p>
        </div>

        <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
          <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">Trend Dashboard</h3>
          <div className="mt-3 space-y-2">
            {trend?.data.series.map((series) => (
              <div className="flex items-center justify-between gap-3 text-sm" key={series.name}>
                <span className="text-slate-600 dark:text-slate-300">{series.name.replace(/_/g, ' ')}</span>
                <span className="font-semibold text-slate-950 dark:text-slate-50">{series.current_value}</span>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div className="grid gap-4 xl:grid-cols-2">
        <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
          <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">KPI Dashboard</h3>
          <div className="mt-3 grid grid-cols-2 gap-2">
            {kpi?.data.items.slice(0, 6).map((item) => (
              <div className="rounded-md bg-slate-50 px-3 py-2 text-xs dark:bg-slate-800" key={item.key}>
                <span className="block text-slate-500 dark:text-slate-400">{item.label}</span>
                <span className="text-sm font-semibold text-slate-950 dark:text-slate-50">
                  {item.value} {item.unit}
                </span>
              </div>
            ))}
          </div>
        </div>

        <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
          <h3 className="text-sm font-semibold text-slate-900 dark:text-slate-100">Benchmark Report</h3>
          <div className="mt-3 space-y-2">
            {benchmark?.data.items.map((item) => (
              <div className="flex items-center justify-between gap-3 text-sm" key={item.key}>
                <span className="text-slate-600 dark:text-slate-300">{item.label}</span>
                <span className="font-semibold text-slate-950 dark:text-slate-50">{item.score}</span>
              </div>
            ))}
          </div>
        </div>
      </div>

      <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
        <h3 className="inline-flex items-center gap-2 text-sm font-semibold text-slate-900 dark:text-slate-100">
          <Lightbulb aria-hidden="true" className="h-4 w-4 text-amber-500" />
          Decision Support Insight
        </h3>
        <div className="mt-3 grid gap-2 md:grid-cols-2">
          {insights?.data.items.slice(0, 4).map((item) => (
            <p className="rounded-md bg-slate-50 px-3 py-2 text-xs text-slate-600 dark:bg-slate-800 dark:text-slate-300" key={item.key}>
              {item.message}
            </p>
          ))}
        </div>
      </div>
    </section>
  );
}

function MetricCard({ caption, icon: Icon, label, value }: { caption: string; icon: LucideIcon; label: string; value: string }) {
  return (
    <div className="rounded-md border border-slate-200 p-3 dark:border-slate-800">
      <div className="flex items-center gap-2 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">
        <Icon aria-hidden="true" className="h-3.5 w-3.5" />
        {label}
      </div>
      <p className="mt-2 text-xl font-semibold text-slate-950 dark:text-slate-50">{value}</p>
      <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">{caption}</p>
    </div>
  );
}
