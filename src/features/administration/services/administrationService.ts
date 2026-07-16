import { apiClient } from '../../../services/apiClient';

export const administrationService = {
  overview: () => apiClient<Record<string, unknown>>('/admin/overview'),
  configurations: () => apiClient<Array<Record<string, unknown>>>('/admin/configurations'),
  configuration: (key: string) => apiClient<Record<string, unknown>>(`/admin/configurations/${key}`),
  updateConfiguration: (key: string, payload: { enabled?: boolean; values?: Record<string, unknown> }) => apiClient<Record<string, unknown>>(`/admin/configurations/${key}`, { method: 'PUT', body: JSON.stringify(payload) }),
  modules: () => apiClient<Array<Record<string, unknown>>>('/admin/modules'),
  features: () => apiClient<Array<Record<string, unknown>>>('/admin/features'),
  updateFeature: (feature: string, state: 'enabled' | 'disabled' | 'hidden') => apiClient<Record<string, unknown>>(`/admin/features/${feature}`, { method: 'PUT', body: JSON.stringify({ state }) }),
  health: () => apiClient<Record<string, unknown>>('/admin/health'),
  security: () => apiClient<Record<string, unknown>>('/admin/security'),
  monitoring: () => apiClient<Record<string, unknown>>('/admin/monitoring'),
  audit: () => apiClient<Record<string, unknown>>('/admin/audit'),
  backup: () => apiClient<Record<string, unknown>>('/admin/backup'),
  integration: () => apiClient<Record<string, unknown>>('/admin/integration'),
};
