import { useMutation, useQueries, useQuery, useQueryClient } from '@tanstack/react-query';
import { masterDataService } from '../services/masterDataService';
import type { MasterDataListParams, MasterDataListResponse, MasterDataPayload, MasterDataResourceKey } from '../types/masterData';

export const masterDataKeys = {
  all: ['master-data'] as const,
  list: (resource: MasterDataResourceKey, params: MasterDataListParams) => [...masterDataKeys.all, resource, 'list', params] as const,
  detail: (resource: MasterDataResourceKey, uuid?: string) => [...masterDataKeys.all, resource, 'detail', uuid] as const,
};

export function useMasterDataList(resource: MasterDataResourceKey, params: MasterDataListParams) {
  return useQuery({
    queryKey: masterDataKeys.list(resource, params),
    queryFn: () => masterDataService.list(resource, params),
    staleTime: 30_000,
  });
}

export function useMasterDataDetail(resource: MasterDataResourceKey, uuid?: string) {
  return useQuery({
    queryKey: masterDataKeys.detail(resource, uuid),
    queryFn: () => masterDataService.detail(resource, uuid ?? ''),
    enabled: Boolean(uuid),
  });
}

export function useCreateMasterData(resource: MasterDataResourceKey) {
  const client = useQueryClient();

  return useMutation({
    mutationFn: (payload: MasterDataPayload) => masterDataService.create(resource, payload),
    onSuccess: () => void client.invalidateQueries({ queryKey: [...masterDataKeys.all, resource] }),
  });
}

export function useUpdateMasterData(resource: MasterDataResourceKey) {
  const client = useQueryClient();

  return useMutation({
    mutationFn: ({ uuid, payload }: { uuid: string; payload: MasterDataPayload }) => masterDataService.update(resource, uuid, payload),
    onSuccess: () => void client.invalidateQueries({ queryKey: [...masterDataKeys.all, resource] }),
  });
}

export function useDeleteMasterData(resource: MasterDataResourceKey) {
  const client = useQueryClient();

  return useMutation({
    mutationFn: (uuid: string) => masterDataService.remove(resource, uuid),
    onSuccess: () => void client.invalidateQueries({ queryKey: [...masterDataKeys.all, resource] }),
  });
}

export function useMasterDataLookups(resources: MasterDataResourceKey[]) {
  const uniqueResources = Array.from(new Set(resources));
  const results = useQueries({
    queries: uniqueResources.map((resource) => ({
      queryKey: masterDataKeys.list(resource, { per_page: 100 }),
      queryFn: () => masterDataService.list(resource, { per_page: 100 }),
      staleTime: 60_000,
    })),
  });

  return uniqueResources.reduce<Partial<Record<MasterDataResourceKey, MasterDataListResponse>>>((accumulator, resource, index) => {
    accumulator[resource] = results[index].data;

    return accumulator;
  }, {} as Record<MasterDataResourceKey, ReturnType<typeof useMasterDataList>['data'] | undefined>);
}
