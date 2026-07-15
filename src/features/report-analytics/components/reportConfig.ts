import {
  Activity,
  BarChart3,
  Boxes,
  ClipboardList,
  FileText,
  Landmark,
  LineChart,
  ShieldCheck,
  Sprout,
} from 'lucide-react';
import type { ReportCategoryKey } from '../types/reportAnalytics';

export const reportCategories: Array<{
  key: ReportCategoryKey;
  label: string;
  description: string;
  icon: typeof FileText;
}> = [
  { key: 'executive', label: 'Executive', description: 'Management summary and KPI overview.', icon: Landmark },
  { key: 'operational', label: 'Operational', description: 'Daily activity and field operations.', icon: Activity },
  { key: 'production', label: 'Production', description: 'Biomass, growth, SR, FCR, and ADG.', icon: Sprout },
  { key: 'inventory', label: 'Inventory', description: 'Stock, movement, valuation, and alerts.', icon: Boxes },
  { key: 'harvest', label: 'Harvest', description: 'Yield, grading, packing, and delivery.', icon: ClipboardList },
  { key: 'financial', label: 'Financial', description: 'Revenue, expense, ROI, and profitability.', icon: BarChart3 },
  { key: 'kpi', label: 'KPI', description: 'Cross-module performance scorecards.', icon: LineChart },
  { key: 'audit', label: 'Audit', description: 'Activity history and compliance trail.', icon: ShieldCheck },
];

export const exportFormats = [
  { key: 'pdf', label: 'PDF' },
  { key: 'xlsx', label: 'Excel' },
  { key: 'csv', label: 'CSV' },
] as const;

export const frequencyOptions = ['daily', 'weekly', 'monthly', 'quarterly', 'yearly'] as const;
