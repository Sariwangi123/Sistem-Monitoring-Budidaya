import { Download, Loader2, PlayCircle } from 'lucide-react';
import { exportFormats } from './reportConfig';
import type { ReportDefinition, ReportExportMetadata, ReportGeneratedResponse } from '../types/reportAnalytics';

type ReportExportPanelProps = {
  exportMetadata?: ReportExportMetadata;
  generated?: ReportGeneratedResponse;
  generating: boolean;
  exporting: boolean;
  onExport: (format: 'pdf' | 'xlsx' | 'csv') => void;
  onGenerate: (format: 'pdf' | 'xlsx' | 'csv' | 'json') => void;
  report?: ReportDefinition;
};

export function ReportExportPanel({
  exportMetadata,
  generated,
  generating,
  exporting,
  onExport,
  onGenerate,
  report,
}: ReportExportPanelProps) {
  return (
    <section aria-labelledby="report-export-heading" className="rounded-md border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div>
        <h2 id="report-export-heading" className="text-sm font-semibold text-slate-900 dark:text-slate-100">Export</h2>
        <p className="mt-1 text-xs text-slate-500 dark:text-slate-400">Preview before export. Metadata adapter only.</p>
      </div>
      <button
        className="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-md bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-70 dark:focus:ring-offset-slate-950"
        disabled={!report || generating}
        onClick={() => onGenerate('json')}
        type="button"
      >
        {generating ? <Loader2 aria-hidden="true" className="h-4 w-4 animate-spin" /> : <PlayCircle aria-hidden="true" className="h-4 w-4" />}
        Generate Preview
      </button>
      <div className="mt-4 grid grid-cols-3 gap-2">
        {exportFormats.map((format) => (
          <button
            className="rounded-md border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-brand hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand disabled:cursor-not-allowed disabled:opacity-60 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
            disabled={!report || exporting}
            key={format.key}
            onClick={() => onExport(format.key)}
            type="button"
          >
            {format.label}
          </button>
        ))}
      </div>
      <div aria-live="polite" className="mt-4 rounded-md border border-slate-200 bg-slate-50 p-3 text-xs text-slate-600 dark:border-slate-800 dark:bg-slate-950 dark:text-slate-300">
        <div className="flex items-center gap-2">
          {exporting || generating ? <Loader2 aria-hidden="true" className="h-4 w-4 animate-spin text-brand" /> : <Download aria-hidden="true" className="h-4 w-4 text-brand" />}
          <span>
            {generated ? `Generated ${generated.export.file_name}` : exportMetadata ? `${exportMetadata.format.toUpperCase()} adapter ready` : 'Waiting for report action'}
          </span>
        </div>
        <p className="mt-2">Production file export: {String(exportMetadata?.production_file_export ?? generated?.export.production_file_export ?? false)}</p>
      </div>
    </section>
  );
}
