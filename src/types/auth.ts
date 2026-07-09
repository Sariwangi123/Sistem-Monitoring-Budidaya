export type LoginPayload = {
  email: string;
  password: string;
  device_name?: string;
};

export type AuthUser = {
  id: number;
  uuid: string;
  name: string;
  email: string;
};

export type AuthSession = {
  user: AuthUser;
  token: string;
  token_type: 'Bearer';
};
