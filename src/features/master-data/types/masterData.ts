import type { PaginationMeta } from '../../../types/api';

export type MasterDataResourceKey =
  | 'companies'
  | 'farms'
  | 'pond-areas'
  | 'ponds'
  | 'fish-species'
  | 'fish-strains'
  | 'feed-brands'
  | 'feed-categories'
  | 'feed-types'
  | 'units'
  | 'suppliers'
  | 'provinces'
  | 'cities'
  | 'districts'
  | 'villages';

export type MasterDataRecord = {
  id?: number;
  uuid?: string;
  created_at?: string;
  updated_at?: string;
  [key: string]: unknown;
};

export type MasterDataPayload = Record<string, string | number | boolean | null>;

export type MasterDataListParams = {
  search?: string;
  page?: number;
  per_page?: number;
};

export type MasterDataListResponse = {
  rows: MasterDataRecord[];
  meta?: PaginationMeta;
};

export type MasterDataFieldType = 'text' | 'email' | 'url' | 'number' | 'textarea' | 'select';

export type MasterDataFieldConfig = {
  key: string;
  label: string;
  type?: MasterDataFieldType;
  required?: boolean;
  lookupResource?: MasterDataResourceKey;
  lookupLabelKey?: string;
  placeholder?: string;
  gridSpan?: 'full';
};

export type MasterDataColumnConfig = {
  key: string;
  label: string;
  lookupResource?: MasterDataResourceKey;
  lookupLabelKey?: string;
};

export type MasterDataResourceConfig = {
  key: MasterDataResourceKey;
  label: string;
  description: string;
  group: 'Organization' | 'Production' | 'Feed' | 'Reference';
  codeKey: string;
  nameKey: string;
  columns: MasterDataColumnConfig[];
  fields: MasterDataFieldConfig[];
};

export type MasterDataModalMode = 'view' | 'create' | 'edit';
