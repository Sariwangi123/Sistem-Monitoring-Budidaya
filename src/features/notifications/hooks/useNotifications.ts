import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import type { ApiSuccessResponse } from '../../../types/api';
import { notificationService } from '../services/notificationService';
import type { NotificationActionResponse, NotificationFilters, NotificationItem, NotificationPreference } from '../types/notification';

export const notificationKeys = {
  all: ['notifications'] as const,
  list: (filters: NotificationFilters) => [...notificationKeys.all, 'list', filters] as const,
  detail: (notificationId?: string) => [...notificationKeys.all, 'detail', notificationId] as const,
  history: (filters: NotificationFilters) => [...notificationKeys.all, 'history', filters] as const,
  statistics: (filters: NotificationFilters) => [...notificationKeys.all, 'statistics', filters] as const,
  preferences: () => [...notificationKeys.all, 'preferences'] as const,
};

export function useNotifications(filters: NotificationFilters) {
  return useQuery({
    queryKey: notificationKeys.list(filters),
    queryFn: () => notificationService.list(filters),
    staleTime: 30_000,
  });
}

export function useNotificationDetail(notificationId?: string) {
  return useQuery({
    enabled: Boolean(notificationId),
    queryKey: notificationKeys.detail(notificationId),
    queryFn: () => notificationService.detail(notificationId ?? ''),
    staleTime: 30_000,
  });
}

export function useNotificationHistory(filters: NotificationFilters) {
  return useQuery({
    queryKey: notificationKeys.history(filters),
    queryFn: () => notificationService.history(filters),
    staleTime: 30_000,
  });
}

export function useNotificationStatistics(filters: NotificationFilters = {}) {
  return useQuery({
    queryKey: notificationKeys.statistics(filters),
    queryFn: () => notificationService.statistics(filters),
    staleTime: 30_000,
  });
}

export function useNotificationPreferences() {
  return useQuery({
    queryKey: notificationKeys.preferences(),
    queryFn: notificationService.preferences,
    staleTime: 30_000,
  });
}

function useNotificationMutation<TData, TVariables>(mutationFn: (variables: TVariables) => Promise<ApiSuccessResponse<TData>>) {
  const queryClient = useQueryClient();

  return useMutation({
    mutationFn,
    onSuccess: () => {
      void queryClient.invalidateQueries({ queryKey: notificationKeys.all });
    },
  });
}

export function useMarkNotificationRead() {
  return useNotificationMutation<NotificationItem, string>(notificationService.markRead);
}

export function useMarkAllNotificationsRead() {
  return useNotificationMutation<NotificationActionResponse, void>(() => notificationService.markAllRead());
}

export function useArchiveNotification() {
  return useNotificationMutation<NotificationItem, string>(notificationService.archive);
}

export function useArchiveAllNotifications() {
  return useNotificationMutation<NotificationActionResponse, void>(() => notificationService.archiveAll());
}

export function useDeleteNotification() {
  return useNotificationMutation<NotificationActionResponse, string>(notificationService.remove);
}

export function useRetryNotification() {
  return useNotificationMutation<NotificationItem, string>(notificationService.retry);
}

export function useUpdateNotificationPreferences() {
  return useNotificationMutation<NotificationPreference, Pick<NotificationPreference, 'in_app_enabled' | 'reminder_enabled' | 'sound_enabled'>>((payload) =>
    notificationService.updatePreferences(payload),
  );
}
