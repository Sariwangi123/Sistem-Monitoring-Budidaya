import type { ApiErrorResponse, ApiSuccessResponse } from '../types/api';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ?? 'http://localhost/api/v1';

export async function apiClient<T>(path: string, init: RequestInit = {}): Promise<ApiSuccessResponse<T>> {
  const response = await fetch(`${API_BASE_URL}${path}`, {
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json',
      ...init.headers,
    },
    ...init,
  });

  const payload = (await response.json()) as ApiSuccessResponse<T> | ApiErrorResponse;

  if (!response.ok || !payload.success) {
    throw new Error(payload.message);
  }

  return payload;
}
