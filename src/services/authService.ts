import { apiClient } from './apiClient';
import type { AuthSession, LoginPayload } from '../types/auth';

export function login(payload: LoginPayload) {
  return apiClient<AuthSession>('/auth/login', {
    method: 'POST',
    body: JSON.stringify(payload),
  });
}

export function logout(token: string) {
  return apiClient<null>('/auth/logout', {
    method: 'POST',
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });
}
