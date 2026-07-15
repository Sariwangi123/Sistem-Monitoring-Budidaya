import { ArrowDownAZ, FileText } from 'lucide-react';
import type { ReportDefinition } from '../types/reportAnalytics';

type ReportListProps = {
  reports: ReportDefinition[];
  selectedReportId?: string;
  onSelect: (report: ReportDefinition) => void;
};

export function ReportList({ reports, selectedReportId, onSelect }: ReportListProps) {
  const sortedReports = [...reports].sort((a, b) => a.name.localeCompare(b.name));

  return (
    <section aria-labelledby="report-list-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="flex items-center justify-between gap-3">
        <div>
          <h2 id="report-list-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Report List</h2>
          <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">Sorted by report name.</p>
        </div>
        <ArrowDownAZ aria-hidden="true" className="h-4 w-4 text-slate-400" />
      </div>
      <div className="mt-4 space-y-2">
        {sortedReports.length === 0 ? (
          <div className="rounded-md border border-dashed border-slate-300 p-4 text-center text-sm text-slate-500 dark:border-slate-700 dark:text-slate-400">
            No Report Available
          </div>
        ) : null}
        {sortedReports.map((report) => (
          <button
            aria-pressed={selectedReportId === report.id}
            className={
              selectedReportId === report.id
                ? 'w-full rounded-md border border-brand bg-brand-soft p-3 text-left focus:outline-none focus:ring-2 focus:ring-brand dark:border-brand dark:bg-slate-800'
                : 'w-full rounded-md border border-slate-200 p-3 text-left hover:border-brand hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand dark:border-slate-800 dark:hover:bg-slate-800'
            }
            key={report.id}
            onClick={() => onSelect(report)}
            type="button"
          >
            <span className="flex items-start gap-3">
              <FileText aria-hidden="true" className="mt-0.5 h-4 w-4 shrink-0 text-brand" />
              <span className="min-w-0">
                <span className="block truncate text-sm font-semibold text-slate-900 dark:text-slate-100">{report.name}</span>
                <span className="mt-1 block text-xs text-slate-500 dark:text-slate-400">
                  {report.source_module} • v{report.version} • {report.supported_export_formats.join(', ').toUpperCase()}
                </span>
              </span>
            </span>
          </button>
        ))}
      </div>
    </section>
  );
}
