import { Star } from 'lucide-react';
import { reportCategories } from './reportConfig';
import type { ReportCategoryKey } from '../types/reportAnalytics';

type ReportNavigationProps = {
  activeCategory: ReportCategoryKey;
  onChange: (category: ReportCategoryKey) => void;
};

export function ReportNavigation({ activeCategory, onChange }: ReportNavigationProps) {
  return (
    <nav aria-label="Report categories" className="rounded-md border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-800 dark:bg-slate-900">
      <div className="mb-3 border-b border-slate-200 pb-3 dark:border-slate-800">
        <p className="text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">Report Workspace</p>
        <button
          className="mt-2 flex w-full items-center gap-2 rounded-md px-2 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-200 dark:hover:bg-slate-800"
          type="button"
        >
          <Star aria-hidden="true" className="h-4 w-4 text-amber-500" />
          Favorite Reports
        </button>
      </div>
      <div className="space-y-1">
        {reportCategories.map((category) => (
          <button
            aria-current={activeCategory === category.key ? 'page' : undefined}
            className={
              activeCategory === category.key
                ? 'flex w-full items-start gap-3 rounded-md bg-brand px-3 py-2 text-left text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 dark:focus:ring-offset-slate-950'
                : 'flex w-full items-start gap-3 rounded-md px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand dark:text-slate-200 dark:hover:bg-slate-800'
            }
            key={category.key}
            onClick={() => onChange(category.key)}
            type="button"
          >
            <category.icon aria-hidden="true" className="mt-0.5 h-4 w-4 shrink-0" />
            <span>
              <span className="block">{category.label}</span>
              <span className={activeCategory === category.key ? 'block text-xs font-normal text-white/80' : 'block text-xs font-normal text-slate-500 dark:text-slate-400'}>
                {category.description}
              </span>
            </span>
          </button>
        ))}
      </div>
    </nav>
  );
}
