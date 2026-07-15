export type DashboardWorkspaceKey =
  | 'executive'
  | 'production'
  | 'inventory'
  | 'harvest'
  | 'finance'
  | 'system';

export type WidgetStatus = 'Loaded' | 'Error' | 'Empty';

export type DashboardFilters = {
  workspace?: DashboardWorkspaceKey;
  period?: string;
  farm_id?: string;
  pond_id?: string;
  culture_cycle_id?: string;
  financial_period_id?: string;
  date_range?: string;
  search?: string;
  unread_only?: boolean;
  severity?: 'Low' | 'Medium' | 'High' | 'Critical';
  category?: string;
};

export type DashboardWidget = {
  key: string;
  workspace: DashboardWorkspaceKey;
  title: string;
  category: string;
  size: 'XS' | 'Small' | 'Medium' | 'Large' | 'Full Width';
  refresh_seconds: number | null;
  status?: WidgetStatus;
  data?: Record<string, unknown> | unknown[];
  error?: string | null;
};

export type DashboardWorkspace = {
  workspace: {
    key: DashboardWorkspaceKey;
    title: string;
    layout: 'Grid' | string;
  };
  widgets: DashboardWidget[];
};

export type DashboardHome = {
  workspace: DashboardWorkspace;
  widgets: DashboardWidget[];
  kpi: DashboardKpiItem[];
  alerts: DashboardAlert[];
};

export type DashboardKpiItem = {
  key: string;
  label: string;
  value: string;
  trend?: string;
  tone?: 'neutral' | 'good' | 'warning' | 'danger';
};

export type DashboardKpiResponse = {
  workspace: DashboardWorkspaceKey;
  items: DashboardKpiItem[];
  trend: unknown[];
  comparison: unknown[];
};

export type DashboardWidgetsResponse = {
  workspace: DashboardWorkspaceKey;
  items: DashboardWidget[];
};

export type DashboardAlert = {
  id?: string | number;
  title?: string;
  message?: string;
  severity?: 'Critical' | 'Warning' | 'Information' | 'High' | 'Medium' | 'Low';
  category?: string;
  status?: string;
};

export type DashboardAlertsResponse = {
  items: DashboardAlert[];
  priority: unknown[];
  status: Record<string, unknown>;
};

export type DashboardTimelineItem = {
  id?: string | number;
  title?: string;
  description?: string;
  type?: string;
  occurred_at?: string;
};

export type DashboardTimelineResponse = {
  recent_activities: DashboardTimelineItem[];
  harvest_events: DashboardTimelineItem[];
  inventory_events: DashboardTimelineItem[];
  financial_events: DashboardTimelineItem[];
};

export type DashboardAnalyticsResponse = {
  workspace: DashboardWorkspaceKey;
  summary: Record<string, unknown>;
  trend: unknown[];
  comparison: unknown[];
  insights?: DashboardInsightCard[];
  recommendations?: DashboardRecommendation[];
  health?: Record<string, DashboardHealthSummary>;
};

export type DashboardHealthSummary = {
  label: string;
  score: number;
  status: string;
  source: string;
  signal_count: number;
};

export type DashboardInsightCard = {
  key: string;
  title: string;
  description: string;
  tone: 'neutral' | 'good' | 'warning' | 'danger';
};

export type DashboardRecommendation = {
  key: string;
  title: string;
  source: string;
  priority: 'Critical' | 'Warning' | 'Information' | string;
  description: string;
  action: string;
  mode: 'rule_based' | string;
};

export type DashboardIntelligenceResponse = {
  operational_summary: Record<string, unknown>;
  kpi_intelligence: {
    items: DashboardKpiItem[];
    trend: unknown[];
    comparison: unknown[];
  };
  trend_indicators: unknown[];
  comparative_indicators: Record<string, unknown>;
  insight_cards: DashboardInsightCard[];
  recommendations: DashboardRecommendation[];
  farm_health_summary: DashboardHealthSummary;
  pond_health_summary: DashboardHealthSummary;
  financial_health_summary: DashboardHealthSummary;
  inventory_health_summary: DashboardHealthSummary;
  production_health_summary: DashboardHealthSummary;
  meta: {
    mode: 'rule_based' | string;
    read_only: boolean;
    roles: string[];
  };
};

export type DashboardCacheStatus = {
  enabled: boolean;
  ttl_seconds: number;
  tracked_keys: number;
};

export type DashboardStatistics = {
  total_widget: number;
  active_widget: number;
  dashboard_load_time: number | null;
  cache_hit_ratio: number | null;
};

export type DashboardRefreshResult = {
  workspace?: DashboardWorkspaceKey;
  cache_cleared: boolean;
};

export type DashboardExportResult = {
  format: 'pdf' | 'excel' | 'csv';
  workspace: DashboardWorkspaceKey;
  status: 'Queued' | string;
};

export type DashboardApiMeta = {
  cache_status?: string;
  execution_time_ms?: number;
  cache_ttl_seconds?: number;
};
