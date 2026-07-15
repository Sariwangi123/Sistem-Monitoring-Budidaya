import { CalendarClock, Loader2, Trash2 } from 'lucide-react';
import { exportFormats, frequencyOptions } from './reportConfig';
import type { ReportDefinition, ReportFilters, ReportScheduleItem } from '../types/reportAnalytics';

type ScheduledReportPanelProps = {
  creating: boolean;
  deleting: boolean;
  onCreate: (frequency: 'daily' | 'weekly' | 'monthly' | 'quarterly' | 'yearly', format: 'pdf' | 'xlsx' | 'csv' | 'json') => void;
  onDelete: (uuid: string) => void;
  report?: ReportDefinition;
  schedules: ReportScheduleItem[];
  filters: ReportFilters;
};

export function ScheduledReportPanel({
  creating,
  deleting,
  filters,
  onCreate,
  onDelete,
  report,
  schedules,
}: ScheduledReportPanelProps) {
  const fallbackUuid = '00000000-0000-4000-8000-000000000001';

  return (
    <section aria-labelledby="report-schedule-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center gap-2">
        <CalendarClock aria-hidden="true" className="h-4 w-4 text-brand" />
        <h2 id="report-schedule-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Scheduled Reports</h2>
      </div>
      <div className="mt-4 grid gap-2 sm:grid-cols-2">
        <button
          className="inline-flex items-center justify-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-brand hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
          disabled={!report || creating}
          onClick={() => onCreate('monthly', 'pdf')}
          type="button"
        >
          {creating ? <Loader2 aria-hidden="true" className="h-4 w-4 animate-spin" /> : null}
          Monthly PDF
        </button>
        <button
          className="inline-flex items-center justify-center gap-2 rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-brand hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
          disabled={!report || creating}
          onClick={() => onCreate('weekly', 'xlsx')}
          type="button"
        >
          Weekly Excel
        </button>
      </div>
      <div className="mt-4 rounded-md border border-slate-200 dark:border-slate-800">
        <div className="grid grid-cols-4 gap-2 border-b border-slate-200 px-3 py-2 text-xs font-semibold text-slate-500 dark:border-slate-800 dark:text-slate-400">
          <span>Report</span>
          <span>Frequency</span>
          <span>Status</span>
          <span>Action</span>
        </div>
        {schedules.length === 0 ? (
          <div className="px-3 py-4 text-sm text-slate-500 dark:text-slate-400">
            No scheduled report. Foundation API is ready for {frequencyOptions.join(', ')} frequencies and {exportFormats.map((item) => item.label).join(', ')} formats.
          </div>
        ) : null}
        {schedules.map((schedule) => (
          <div className="grid grid-cols-4 gap-2 border-t border-slate-100 px-3 py-3 text-sm dark:border-slate-800" key={schedule.uuid}>
            <span className="truncate text-slate-800 dark:text-slate-200">{schedule.report?.name ?? report?.name ?? 'Report'}</span>
            <span className="text-slate-600 dark:text-slate-300">{schedule.frequency}</span>
            <span className="text-slate-600 dark:text-slate-300">{schedule.status}</span>
            <button
              aria-label="Delete scheduled report"
              className="inline-flex w-fit items-center gap-1 rounded-md p-1 text-red-600 hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 dark:hover:bg-red-950"
              disabled={deleting}
              onClick={() => onDelete(schedule.uuid || fallbackUuid)}
              type="button"
            >
              <Trash2 aria-hidden="true" className="h-4 w-4" />
            </button>
          </div>
        ))}
      </div>
      <p className="mt-3 text-xs text-slate-500 dark:text-slate-400">
        Active filters are kept for the session: {Object.values(filters).filter(Boolean).length} applied.
      </p>
    </section>
  );
}
