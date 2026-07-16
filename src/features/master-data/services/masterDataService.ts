import { apiClient } from '../../../services/apiClient';
import type { ApiSuccessResponse } from '../../../types/api';
import type { MasterDataListParams, MasterDataListResponse, MasterDataPayload, MasterDataRecord, MasterDataResourceKey } from '../types/masterData';

function queryString(params: MasterDataListParams = {}) {
  const search = new URLSearchParams();

  Object.entries(params).forEach(([key, value]) => {
    if (value !== undefined && value !== null && value !== '') {
      search.set(key, String(value));
    }
  });

  const value = search.toString();

  return value ? `?${value}` : '';
}

function normalizeListResponse(response: ApiSuccessResponse<MasterDataRecord[]>): MasterDataListResponse {
  return {
    rows: response.data,
    meta: response.meta as MasterDataListResponse['meta'],
  };
}

export const masterDataService = {
  async list(resource: MasterDataResourceKey, params: MasterDataListParams = {}) {
    const response = await apiClient<MasterDataRecord[]>(`/master/${resource}${queryString(params)}`);

    return normalizeListResponse(response);
  },

  detail(resource: MasterDataResourceKey, uuid: string) {
    return apiClient<MasterDataRecord>(`/master/${resource}/${uuid}`);
  },

  create(resource: MasterDataResourceKey, payload: MasterDataPayload) {
    return apiClient<MasterDataRecord>(`/master/${resource}`, {
      method: 'POST',
      body: JSON.stringify(payload),
    });
  },

  update(resource: MasterDataResourceKey, uuid: string, payload: MasterDataPayload) {
    return apiClient<MasterDataRecord>(`/master/${resource}/${uuid}`, {
      method: 'PUT',
      body: JSON.stringify(payload),
    });
  },

  remove(resource: MasterDataResourceKey, uuid: string) {
    return apiClient<null>(`/master/${resource}/${uuid}`, {
      method: 'DELETE',
    });
  },
};
