import type { ApiErrorResponse, ApiSuccessResponse } from '../types/api';
import { useAuthStore } from '../stores/authStore';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ?? 'http://localhost/api/v1';

export async function apiClient<T>(path: string, init: RequestInit = {}): Promise<ApiSuccessResponse<T>> {
  const token = useAuthStore.getState().session?.token;
  const headers = new Headers(init.headers);

  headers.set('Accept', 'application/json');
  headers.set('Content-Type', 'application/json');

  if (token && !headers.has('Authorization')) {
    headers.set('Authorization', `Bearer ${token}`);
  }

  const response = await fetch(`${API_BASE_URL}${path}`, {
    ...init,
    headers,
  });

  const payload = (await response.json()) as ApiSuccessResponse<T> | ApiErrorResponse;

  if (!response.ok || !payload.success) {
    throw new Error(payload.message);
  }

  return payload;
}
