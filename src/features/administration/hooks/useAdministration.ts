import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { administrationService } from '../services/administrationService';

const keys = { all: ['administration'] as const, overview: () => [...keys.all, 'overview'] as const };
const query = <T,>(key: readonly unknown[], fn: () => Promise<T>, interval?: number) => useQuery({ queryKey: key, queryFn: fn, staleTime: 30_000, refetchInterval: interval });
export const useAdministrationOverview = () => query(keys.overview(), administrationService.overview);
export const useAdministrationConfigurations = () => query([...keys.all, 'configurations'], administrationService.configurations);
export const useAdministrationModules = () => query([...keys.all, 'modules'], administrationService.modules);
export const useAdministrationFeatures = () => query([...keys.all, 'features'], administrationService.features);
export const useAdministrationHealth = () => query([...keys.all, 'health'], administrationService.health, 60_000);
export const useAdministrationSecurity = () => query([...keys.all, 'security'], administrationService.security);
export const useAdministrationMonitoring = () => query([...keys.all, 'monitoring'], administrationService.monitoring, 60_000);
export const useAdministrationAudit = () => query([...keys.all, 'audit'], administrationService.audit);
export const useAdministrationBackup = () => query([...keys.all, 'backup'], administrationService.backup);
export const useAdministrationIntegration = () => query([...keys.all, 'integration'], administrationService.integration);
export function useUpdateConfiguration() { const client = useQueryClient(); return useMutation({ mutationFn: ({ key, enabled }: { key: string; enabled: boolean }) => administrationService.updateConfiguration(key, { enabled }), onSuccess: () => void client.invalidateQueries({ queryKey: keys.all }) }); }
export function useUpdateFeature() { const client = useQueryClient(); return useMutation({ mutationFn: ({ feature, state }: { feature: string; state: 'enabled' | 'disabled' | 'hidden' }) => administrationService.updateFeature(feature, state), onSuccess: () => void client.invalidateQueries({ queryKey: keys.all }) }); }
