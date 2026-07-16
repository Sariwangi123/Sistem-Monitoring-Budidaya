import {
  Bell,
  Boxes,
  CircleAlert,
  ClipboardList,
  Landmark,
  ShieldCheck,
  SlidersHorizontal,
  Sprout,
  type LucideIcon,
} from 'lucide-react';
import type { NotificationCategory, NotificationPriority, NotificationStatus } from '../types/notification';

export type NotificationView = 'all' | 'unread' | 'critical' | 'archive' | NotificationCategory;

export const notificationViews: Array<{ key: NotificationView; label: string; icon: LucideIcon }> = [
  { key: 'all', label: 'All notifications', icon: Bell },
  { key: 'unread', label: 'Unread', icon: CircleAlert },
  { key: 'critical', label: 'Critical', icon: CircleAlert },
  { key: 'operational', label: 'Operational', icon: ClipboardList },
  { key: 'inventory', label: 'Inventory', icon: Boxes },
  { key: 'harvest', label: 'Harvest', icon: Sprout },
  { key: 'financial', label: 'Financial', icon: Landmark },
  { key: 'executive', label: 'Executive', icon: SlidersHorizontal },
  { key: 'security', label: 'Security', icon: ShieldCheck },
  { key: 'system', label: 'System', icon: Bell },
  { key: 'archive', label: 'Archive', icon: Bell },
];

export const categoryIcons: Record<string, LucideIcon> = {
  operational: ClipboardList,
  inventory: Boxes,
  harvest: Sprout,
  financial: Landmark,
  executive: SlidersHorizontal,
  security: ShieldCheck,
  system: Bell,
};

export const priorityClasses: Record<string, string> = {
  critical: 'border-red-200 bg-red-50 text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-200',
  high: 'border-orange-200 bg-orange-50 text-orange-700 dark:border-orange-900 dark:bg-orange-950 dark:text-orange-200',
  medium: 'border-amber-200 bg-amber-50 text-amber-700 dark:border-amber-900 dark:bg-amber-950 dark:text-amber-200',
  low: 'border-sky-200 bg-sky-50 text-sky-700 dark:border-sky-900 dark:bg-sky-950 dark:text-sky-200',
  information: 'border-slate-200 bg-slate-50 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200',
};

export const statusClasses: Record<string, string> = {
  delivered: 'text-emerald-700 dark:text-emerald-300',
  sent: 'text-emerald-700 dark:text-emerald-300',
  read: 'text-slate-500 dark:text-slate-400',
  archived: 'text-slate-500 dark:text-slate-400',
  failed: 'text-red-700 dark:text-red-300',
  retry: 'text-amber-700 dark:text-amber-300',
  pending: 'text-sky-700 dark:text-sky-300',
  processing: 'text-sky-700 dark:text-sky-300',
};

export const statuses: NotificationStatus[] = ['pending', 'sent', 'delivered', 'read', 'archived', 'failed', 'processing', 'retry'];
export const priorities: NotificationPriority[] = ['critical', 'high', 'medium', 'low', 'information'];
export const categories: NotificationCategory[] = ['operational', 'inventory', 'harvest', 'financial', 'executive', 'security', 'system', 'audit'];

export function label(value: string) {
  return value.replace(/_/g, ' ').replace(/\b\w/g, (letter: string) => letter.toUpperCase());
}
