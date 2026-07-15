import { BarChart3, FileCheck2 } from 'lucide-react';
import type {
  ReportCategoryResponse,
  ReportDefinition,
  ReportGeneratedResponse,
  ReportPreviewSection,
} from '../types/reportAnalytics';
import { ReportEmptyState } from './ReportStates';

type ReportPreviewPanelProps = {
  categoryData?: ReportCategoryResponse;
  generated?: ReportGeneratedResponse;
  report?: ReportDefinition;
  lastGeneratedAt?: Date | null;
};

const chartBars = ['h-10', 'h-16', 'h-12', 'h-20', 'h-14', 'h-24'];

export function ReportPreviewPanel({ categoryData, generated, report, lastGeneratedAt }: ReportPreviewPanelProps) {
  const sections = generated?.export.payload.build.sections.map((section) => ({
    key: section.key,
    title: section.title,
    status: 'Generated',
    items: [],
  })) ?? categoryData?.sections ?? [];

  if (!report) {
    return <ReportEmptyState message="Select a report to preview." />;
  }

  return (
    <section aria-labelledby="report-preview-heading" className="rounded-md border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="border-b border-slate-200 p-4 dark:border-slate-800">
        <div className="flex flex-wrap items-start justify-between gap-3">
          <div>
            <p className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Preview</p>
            <h2 id="report-preview-heading" className="mt-1 text-lg font-semibold text-slate-950 dark:text-slate-50">{report.name}</h2>
            <p className="mt-1 text-sm text-slate-600 dark:text-slate-300">
              {report.source_module} • Template {generated?.template.key ?? report.template}
            </p>
          </div>
          <span className="inline-flex items-center gap-2 rounded-md border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-semibold text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950 dark:text-emerald-200">
            <FileCheck2 aria-hidden="true" className="h-4 w-4" />
            Read Only
          </span>
        </div>
      </div>

      <div className="space-y-4 p-4">
        <div className="rounded-md border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950">
          <p className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Cover</p>
          <p className="mt-2 text-xl font-semibold text-slate-950 dark:text-slate-50">{report.name}</p>
          <p className="mt-1 text-sm text-slate-600 dark:text-slate-300">
            Generated metadata: {lastGeneratedAt ? lastGeneratedAt.toLocaleString('id-ID') : 'Waiting for preview'}
          </p>
        </div>

        <div className="grid gap-3 md:grid-cols-2">
          <div className="rounded-md border border-slate-200 p-4 dark:border-slate-800">
            <p className="text-sm font-semibold text-slate-900 dark:text-slate-100">Summary</p>
            <p className="mt-2 text-sm text-slate-600 dark:text-slate-300">
              {categoryData?.summary.status ?? 'Preview ready'} using {categoryData?.summary.source_strategy ?? 'Universal Report Engine'}.
            </p>
          </div>
          <div className="rounded-md border border-slate-200 p-4 dark:border-slate-800">
            <div className="flex items-center gap-2">
              <BarChart3 aria-hidden="true" className="h-4 w-4 text-brand" />
              <p className="text-sm font-semibold text-slate-900 dark:text-slate-100">Chart Placeholder</p>
            </div>
            <div className="mt-4 flex h-28 items-end gap-2" aria-label="Chart preview placeholder">
              {chartBars.map((height, index) => (
                <span className={`${height} flex-1 rounded-t bg-brand/70`} key={index} />
              ))}
            </div>
          </div>
        </div>

        <div className="overflow-hidden rounded-md border border-slate-200 dark:border-slate-800">
          <table className="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
            <thead className="bg-slate-50 dark:bg-slate-950">
              <tr>
                <th className="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Section</th>
                <th className="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Status</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100 dark:divide-slate-800">
              {sections.map((section: ReportPreviewSection) => (
                <tr key={section.key}>
                  <td className="px-4 py-3 text-slate-800 dark:text-slate-200">{section.title}</td>
                  <td className="px-4 py-3 text-slate-600 dark:text-slate-300">{section.status}</td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        <footer className="rounded-md border border-slate-200 px-4 py-3 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">
          Footer: Preview only. Production PDF, Excel, and CSV file generation is not executed in this workspace.
        </footer>
      </div>
    </section>
  );
}
