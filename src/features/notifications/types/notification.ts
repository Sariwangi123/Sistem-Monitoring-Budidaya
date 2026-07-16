export type NotificationStatus = 'pending' | 'sent' | 'delivered' | 'read' | 'archived' | 'failed' | 'processing' | 'retry';
export type NotificationPriority = 'critical' | 'high' | 'medium' | 'low' | 'information';
export type NotificationCategory =
  | 'operational'
  | 'inventory'
  | 'harvest'
  | 'financial'
  | 'executive'
  | 'security'
  | 'system'
  | 'audit';

export type NotificationFilters = {
  status?: NotificationStatus;
  category?: NotificationCategory;
  priority?: NotificationPriority;
  source_module?: string;
  unread_only?: boolean;
  search?: string;
  date_from?: string;
  date_to?: string;
  page?: number;
  per_page?: number;
  sort?: string;
  direction?: 'asc' | 'desc';
};

export type NotificationItem = {
  id: string;
  event_name: string;
  source_module: string;
  notification_type: string;
  category: NotificationCategory | string;
  priority: NotificationPriority | string;
  channel: string;
  recipient_type: string;
  title: string;
  message: string;
  action_url: string | null;
  status: NotificationStatus | string;
  attempts: number;
  max_attempts: number;
  metadata: Record<string, unknown> | null;
  created_at: string | null;
  read_at: string | null;
  archived_at: string | null;
  delivered_at: string | null;
};

export type NotificationPagination = {
  current_page: number;
  per_page: number;
  total: number;
  last_page: number;
};

import type { ApiSuccessResponse } from '../../../types/api';

export type NotificationListResponse = ApiSuccessResponse<NotificationItem[]> & {
  pagination: NotificationPagination;
  total_unread?: number;
};

export type NotificationHistoryItem = {
  id: string;
  notification_id: string | null;
  event_name: string;
  channel: string;
  recipient_type: string;
  status: string;
  attempt: number;
  metadata: Record<string, unknown> | null;
  delivered_at: string | null;
  read_at: string | null;
  created_at: string | null;
};

export type NotificationHistoryResponse = ApiSuccessResponse<NotificationHistoryItem[]> & {
  pagination: NotificationPagination;
};

export type NotificationStatistics = {
  total_notification: number;
  total_unread: number;
  total_archived: number;
  by_category: Record<string, number>;
  by_priority: Record<string, number>;
  by_status: Record<string, number>;
};

export type NotificationPreference = {
  id: string;
  in_app_enabled: boolean;
  reminder_enabled: boolean;
  sound_enabled: boolean;
  email_enabled: false;
  whatsapp_enabled: false;
  desktop_notification_enabled: false;
  external_channel_delivery_enabled: false;
};

export type NotificationActionResponse = {
  deleted?: boolean;
  updated_count?: number;
};
