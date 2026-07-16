import { apiClient } from '../../../services/apiClient';
import type {
  NotificationActionResponse,
  NotificationFilters,
  NotificationHistoryItem,
  NotificationHistoryResponse,
  NotificationItem,
  NotificationListResponse,
  NotificationPreference,
  NotificationStatistics,
} from '../types/notification';

function queryString(filters: NotificationFilters = {}) {
  const search = new URLSearchParams();

  Object.entries(filters).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== '') {
      search.set(key, String(value));
    }
  });

  const value = search.toString();

  return value ? `?${value}` : '';
}

export const notificationService = {
  list(filters: NotificationFilters) {
    return apiClient<NotificationItem[]>(`/notifications${queryString(filters)}`) as Promise<NotificationListResponse>;
  },

  detail(notificationId: string) {
    return apiClient<NotificationItem>(`/notifications/${notificationId}`);
  },

  history(filters: NotificationFilters) {
    return apiClient<NotificationHistoryItem[]>(`/notifications/history${queryString(filters)}`) as Promise<NotificationHistoryResponse>;
  },

  statistics(filters: NotificationFilters) {
    return apiClient<NotificationStatistics>(`/notifications/statistics${queryString(filters)}`);
  },

  preferences() {
    return apiClient<NotificationPreference>('/notifications/preferences');
  },

  updatePreferences(payload: Pick<NotificationPreference, 'in_app_enabled' | 'reminder_enabled' | 'sound_enabled'>) {
    return apiClient<NotificationPreference>('/notifications/preferences', {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  },

  markRead(notificationId: string) {
    return apiClient<NotificationItem>(`/notifications/${notificationId}/read`, { method: 'PATCH' });
  },

  markAllRead() {
    return apiClient<NotificationActionResponse>('/notifications/read-all', { method: 'PATCH' });
  },

  archive(notificationId: string) {
    return apiClient<NotificationItem>(`/notifications/${notificationId}/archive`, { method: 'PATCH' });
  },

  archiveAll() {
    return apiClient<NotificationActionResponse>('/notifications/archive-all', { method: 'PATCH' });
  },

  remove(notificationId: string) {
    return apiClient<NotificationActionResponse>(`/notifications/${notificationId}`, { method: 'DELETE' });
  },

  retry(notificationId: string) {
    return apiClient<NotificationItem>(`/notifications/${notificationId}/retry`, { method: 'POST' });
  },
};
