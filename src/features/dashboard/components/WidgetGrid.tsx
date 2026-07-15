import { widgetBlueprints } from './dashboardConfig';
import { WidgetContainer } from './WidgetContainer';
import type { DashboardWidget, DashboardWorkspaceKey } from '../types/dashboard';

type WidgetGridProps = {
  workspace: DashboardWorkspaceKey;
  widgets?: DashboardWidget[];
  refreshingWidgetKey?: string;
  lastUpdated: Date | null;
  onExportWidget: (widgetKey: string) => void;
  onRefreshWidget: (widgetKey: string) => void;
};

export function WidgetGrid({
  workspace,
  widgets = [],
  refreshingWidgetKey,
  lastUpdated,
  onExportWidget,
  onRefreshWidget,
}: WidgetGridProps) {
  const blueprints = widgetBlueprints.filter((widget) => widget.workspace === workspace);

  return (
    <section aria-label="Workspace widget grid" className="grid grid-cols-1 gap-4 md:grid-cols-6 xl:grid-cols-12">
      {blueprints.map((blueprint) => (
        <WidgetContainer
          blueprint={blueprint}
          key={blueprint.key}
          lastUpdated={lastUpdated}
          onExport={onExportWidget}
          onRefresh={onRefreshWidget}
          refreshing={refreshingWidgetKey === blueprint.key}
          widget={widgets.find((widget) => widget.key === blueprint.key)}
        />
      ))}
    </section>
  );
}
