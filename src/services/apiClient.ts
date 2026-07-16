import type { ApiSuccessResponse } from '../types/api';
import { useAuthStore } from '../stores/authStore';

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ?? 'http://localhost/api/v1';

type ApiRawResponse<T> = {
  success?: boolean;
  message?: string;
  data?: T;
  meta?: Record<string, unknown>;
  links?: Record<string, unknown>;
  errors?: Record<string, string[]>;
};

export class ApiClientError extends Error {
  errors?: Record<string, string[]>;

  constructor(message: string, errors?: Record<string, string[]>) {
    super(message);
    this.name = 'ApiClientError';
    this.errors = errors;
  }
}

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

  const payload = (await response.json()) as ApiRawResponse<T>;

  if (!response.ok || !payload.success) {
    if (response.ok && payload.success === undefined && 'data' in payload) {
      return {
        success: true,
        message: payload.message ?? 'Success',
        data: payload.data as T,
        meta: payload.meta,
        links: payload.links,
      };
    }

    throw new ApiClientError(payload.message ?? 'Request failed', 'errors' in payload ? payload.errors : undefined);
  }

  return payload as ApiSuccessResponse<T>;
}
