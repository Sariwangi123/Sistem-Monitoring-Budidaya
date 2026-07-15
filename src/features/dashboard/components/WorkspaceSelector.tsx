import { Check } from 'lucide-react';
import { workspaceOptions } from './dashboardConfig';
import type { DashboardWorkspaceKey } from '../types/dashboard';

type WorkspaceSelectorProps = {
  activeWorkspace: DashboardWorkspaceKey;
  allowedWorkspaces: DashboardWorkspaceKey[];
  onChange: (workspace: DashboardWorkspaceKey) => void;
};

export function WorkspaceSelector({ activeWorkspace, allowedWorkspaces, onChange }: WorkspaceSelectorProps) {
  const options = workspaceOptions.filter((workspace) => allowedWorkspaces.includes(workspace.key));

  return (
    <div aria-label="Workspace selector" className="flex flex-wrap gap-2" role="tablist">
      {options.map((workspace) => {
        const active = workspace.key === activeWorkspace;

        return (
          <button
            aria-selected={active}
            className={
              active
                ? 'inline-flex items-center gap-2 rounded-md bg-brand px-3 py-2 text-sm font-semibold text-white focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 dark:focus:ring-offset-slate-950'
                : 'inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-brand dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:bg-slate-800'
            }
            key={workspace.key}
            onClick={() => onChange(workspace.key)}
            role="tab"
            type="button"
          >
            {active ? <Check aria-hidden="true" className="h-4 w-4" /> : null}
            {workspace.label}
          </button>
        );
      })}
    </div>
  );
}
