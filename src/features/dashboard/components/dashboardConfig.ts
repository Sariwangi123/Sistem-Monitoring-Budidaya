import {
  Activity,
  AlertTriangle,
  Archive,
  Banknote,
  BarChart3,
  Boxes,
  CalendarDays,
  ClipboardList,
  Clock3,
  Database,
  DollarSign,
  Droplets,
  Factory,
  Gauge,
  HeartPulse,
  LineChart,
  PackageCheck,
  Percent,
  Scale,
  Server,
  ShieldCheck,
  Sprout,
  Truck,
  Users,
  WalletCards,
  Wheat,
} from 'lucide-react';
import type { LucideIcon } from 'lucide-react';
import type { DashboardKpiItem, DashboardWidget, DashboardWorkspaceKey } from '../types/dashboard';

export type WorkspaceOption = {
  key: DashboardWorkspaceKey;
  label: string;
  roles: string[];
};

export type WidgetBlueprint = Pick<DashboardWidget, 'key' | 'workspace' | 'title' | 'category' | 'size'> & {
  icon: LucideIcon;
};

export const workspaceOptions: WorkspaceOption[] = [
  { key: 'executive', label: 'Executive', roles: ['super-admin', 'farm-owner', 'director', 'viewer'] },
  { key: 'production', label: 'Production', roles: ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician'] },
  { key: 'inventory', label: 'Inventory', roles: ['super-admin', 'farm-manager', 'warehouse-staff'] },
  { key: 'harvest', label: 'Harvest', roles: ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician'] },
  { key: 'finance', label: 'Finance', roles: ['super-admin', 'farm-owner', 'director', 'finance-staff'] },
  { key: 'system', label: 'Administration', roles: ['super-admin'] },
];

export const kpiFallback: DashboardKpiItem[] = [
  { key: 'revenue', label: 'Revenue', value: 'No Data', tone: 'neutral' },
  { key: 'profit', label: 'Profit', value: 'No Data', tone: 'neutral' },
  { key: 'biomass', label: 'Biomass', value: 'No Data', tone: 'neutral' },
  { key: 'stock', label: 'Stock', value: 'No Data', tone: 'neutral' },
  { key: 'harvest', label: 'Harvest', value: 'No Data', tone: 'neutral' },
  { key: 'sr', label: 'SR', value: 'No Data', tone: 'neutral' },
  { key: 'fcr', label: 'FCR', value: 'No Data', tone: 'neutral' },
  { key: 'roi', label: 'ROI', value: 'No Data', tone: 'neutral' },
];

export const widgetBlueprints: WidgetBlueprint[] = [
  { key: 'financial-summary', workspace: 'executive', title: 'Financial Summary', category: 'Finance', size: 'Large', icon: WalletCards },
  { key: 'revenue-trend', workspace: 'executive', title: 'Revenue Trend', category: 'Finance', size: 'Medium', icon: LineChart },
  { key: 'profit-trend', workspace: 'executive', title: 'Profit Trend', category: 'Finance', size: 'Medium', icon: BarChart3 },
  { key: 'production-summary', workspace: 'executive', title: 'Production Summary', category: 'Production', size: 'Large', icon: Sprout },
  { key: 'harvest-summary', workspace: 'executive', title: 'Harvest Summary', category: 'Harvest', size: 'Medium', icon: Wheat },
  { key: 'financial-health-score', workspace: 'executive', title: 'Financial Health Score', category: 'Finance', size: 'Medium', icon: HeartPulse },
  { key: 'active-culture-cycle', workspace: 'production', title: 'Active Culture Cycle', category: 'Production', size: 'Large', icon: Activity },
  { key: 'feeding-today', workspace: 'production', title: 'Feeding Today', category: 'Activities', size: 'Medium', icon: ClipboardList },
  { key: 'water-quality', workspace: 'production', title: 'Water Quality', category: 'Activities', size: 'Medium', icon: Droplets },
  { key: 'biomass', workspace: 'production', title: 'Biomass', category: 'Production', size: 'Small', icon: Scale },
  { key: 'survival-rate', workspace: 'production', title: 'SR', category: 'Production', size: 'Small', icon: Percent },
  { key: 'feed-conversion-ratio', workspace: 'production', title: 'FCR', category: 'Production', size: 'Small', icon: Gauge },
  { key: 'average-daily-gain', workspace: 'production', title: 'ADG', category: 'Production', size: 'Small', icon: BarChart3 },
  { key: 'daily-activities', workspace: 'production', title: 'Daily Activities', category: 'Activities', size: 'Large', icon: CalendarDays },
  { key: 'current-stock', workspace: 'inventory', title: 'Current Stock', category: 'Inventory', size: 'Large', icon: Boxes },
  { key: 'low-stock', workspace: 'inventory', title: 'Low Stock', category: 'Inventory', size: 'Medium', icon: AlertTriangle },
  { key: 'expired-inventory', workspace: 'inventory', title: 'Expired Inventory', category: 'Inventory', size: 'Medium', icon: Archive },
  { key: 'inventory-movement', workspace: 'inventory', title: 'Inventory Movement', category: 'Inventory', size: 'Large', icon: PackageCheck },
  { key: 'warehouse-utilization', workspace: 'inventory', title: 'Warehouse Utilization', category: 'Warehouse', size: 'Medium', icon: Factory },
  { key: 'stock-trend', workspace: 'inventory', title: 'Stock Trend', category: 'Inventory', size: 'Medium', icon: LineChart },
  { key: 'harvest-schedule', workspace: 'harvest', title: 'Harvest Schedule', category: 'Harvest', size: 'Large', icon: CalendarDays },
  { key: 'harvest-progress', workspace: 'harvest', title: 'Harvest Progress', category: 'Harvest', size: 'Medium', icon: Wheat },
  { key: 'grade-distribution', workspace: 'harvest', title: 'Grade Distribution', category: 'Harvest', size: 'Medium', icon: BarChart3 },
  { key: 'yield-analysis', workspace: 'harvest', title: 'Yield Analysis', category: 'Harvest', size: 'Large', icon: Scale },
  { key: 'pending-delivery', workspace: 'harvest', title: 'Pending Delivery', category: 'Delivery', size: 'Medium', icon: Truck },
  { key: 'harvest-trend', workspace: 'harvest', title: 'Harvest Trend', category: 'Harvest', size: 'Medium', icon: LineChart },
  { key: 'revenue', workspace: 'finance', title: 'Revenue', category: 'Finance', size: 'Medium', icon: DollarSign },
  { key: 'expense', workspace: 'finance', title: 'Expense', category: 'Finance', size: 'Medium', icon: Banknote },
  { key: 'financial-ledger', workspace: 'finance', title: 'Financial Ledger', category: 'Finance', size: 'Large', icon: Database },
  { key: 'profit-summary', workspace: 'finance', title: 'Profit Summary', category: 'Finance', size: 'Large', icon: WalletCards },
  { key: 'cost-per-kg', workspace: 'finance', title: 'Cost per KG', category: 'Finance', size: 'Small', icon: Scale },
  { key: 'finance-roi', workspace: 'finance', title: 'ROI', category: 'Finance', size: 'Small', icon: Percent },
  { key: 'financial-trend', workspace: 'finance', title: 'Financial Trend', category: 'Finance', size: 'Large', icon: LineChart },
  { key: 'active-user', workspace: 'system', title: 'Active User', category: 'System', size: 'Medium', icon: Users },
  { key: 'queue-status', workspace: 'system', title: 'Queue Status', category: 'System', size: 'Medium', icon: Server },
  { key: 'api-status', workspace: 'system', title: 'API Status', category: 'System', size: 'Medium', icon: ShieldCheck },
  { key: 'storage', workspace: 'system', title: 'Storage', category: 'System', size: 'Medium', icon: Database },
  { key: 'job-monitor', workspace: 'system', title: 'Job Monitor', category: 'System', size: 'Large', icon: Clock3 },
  { key: 'audit-activity', workspace: 'system', title: 'Audit Activity', category: 'System', size: 'Large', icon: Activity },
];
