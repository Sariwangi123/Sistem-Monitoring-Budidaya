import { Plus, RefreshCw, Search } from 'lucide-react';
import { useMemo, useState } from 'react';
import { ApiClientError } from '../services/apiClient';
import { useAuthStore } from '../stores/authStore';
import { masterDataResources } from '../features/master-data/components/masterDataConfig';
import { MasterDataFormModal } from '../features/master-data/components/MasterDataFormModal';
import { MasterDataTable } from '../features/master-data/components/MasterDataTable';
import { useCreateMasterData, useDeleteMasterData, useMasterDataList, useMasterDataLookups, useUpdateMasterData } from '../features/master-data/hooks/useMasterData';
import type { MasterDataColumnConfig, MasterDataModalMode, MasterDataPayload, MasterDataRecord, MasterDataResourceKey } from '../features/master-data/types/masterData';

type ModalState = {
  mode: MasterDataModalMode;
  record?: MasterDataRecord;
};

const permissions = {
  view: 'master-data.view',
  create: 'master-data.create',
  update: 'master-data.update',
  delete: 'master-data.delete',
};

function buildInitialPayload(record: MasterDataRecord | undefined, keys: string[]): MasterDataPayload {
  return keys.reduce<MasterDataPayload>((payload, key) => {
    const value = record?.[key];
    payload[key] = typeof value === 'string' || typeof value === 'number' || typeof value === 'boolean' || value === null ? value : null;

    return payload;
  }, {});
}

function stringifyCell(value: unknown) {
  if (typeof value === 'boolean') {
    return value ? 'Yes' : 'No';
  }

  if (value === null || value === undefined || value === '') {
    return '-';
  }

  return String(value);
}

function readErrorMessage(error: unknown) {
  if (error instanceof ApiClientError) {
    const firstField = error.errors ? Object.values(error.errors)[0]?.[0] : undefined;

    return firstField ?? error.message;
  }

  return error instanceof Error ? error.message : 'Request failed';
}

export function MasterDataPage() {
  const [resourceKey, setResourceKey] = useState<MasterDataResourceKey>('companies');
  const [search, setSearch] = useState('');
  const [page, setPage] = useState(1);
  const [modal, setModal] = useState<ModalState | null>(null);
  const [formValue, setFormValue] = useState<MasterDataPayload>({});
  const [feedback, setFeedback] = useState<{ type: 'success' | 'error'; message: string } | null>(null);

  const resource = useMemo(() => masterDataResources.find((item) => item.key === resourceKey) ?? masterDataResources[0], [resourceKey]);
  const listQuery = useMasterDataList(resource.key, { search, page, per_page: 15 });
  const createMutation = useCreateMasterData(resource.key);
  const updateMutation = useUpdateMasterData(resource.key);
  const deleteMutation = useDeleteMasterData(resource.key);
  const sessionPermissions = useAuthStore((state) => state.session?.user.permissions);
  const unrestrictedSession = !sessionPermissions || sessionPermissions.length === 0;
  const can = (permission: string) => unrestrictedSession || sessionPermissions.includes(permission);

  const lookupResourceKeys = useMemo(
    () =>
      Array.from(
        new Set(
          [
            ...resource.fields.map((field) => field.lookupResource),
            ...resource.columns.map((column) => column.lookupResource),
          ].filter(Boolean) as MasterDataResourceKey[],
        ),
      ),
    [resource],
  );
  const lookups = useMasterDataLookups(lookupResourceKeys);
  const lookupOptions = useMemo(
    () =>
      lookupResourceKeys.reduce<Partial<Record<MasterDataResourceKey, MasterDataRecord[]>>>((accumulator, key) => {
        accumulator[key] = lookups[key]?.rows ?? [];

        return accumulator;
      }, {}),
    [lookupResourceKeys, lookups],
  );

  const rows = listQuery.data?.rows ?? [];
  const meta = listQuery.data?.meta;
  const currentPage = meta?.current_page ?? page;
  const lastPage = meta?.last_page ?? 1;
  const fieldKeys = resource.fields.map((field) => field.key);
  const busy = createMutation.isPending || updateMutation.isPending || deleteMutation.isPending;
  const mutationError = createMutation.error ?? updateMutation.error ?? deleteMutation.error;

  function resolveLookupLabel(row: MasterDataRecord, column: MasterDataColumnConfig) {
    const value = row[column.key];

    if (!column.lookupResource || value === null || value === undefined) {
      return stringifyCell(value);
    }

    const option = lookupOptions[column.lookupResource]?.find((item) => item.id === Number(value));
    const label = column.lookupLabelKey ? option?.[column.lookupLabelKey] : undefined;

    return stringifyCell(label ?? value);
  }

  function openModal(mode: MasterDataModalMode, record?: MasterDataRecord) {
    setFeedback(null);
    setModal({ mode, record });
    setFormValue(buildInitialPayload(record, fieldKeys));
  }

  function closeModal() {
    setModal(null);
    setFormValue({});
  }

  function switchResource(key: MasterDataResourceKey) {
    setResourceKey(key);
    setSearch('');
    setPage(1);
    closeModal();
    setFeedback(null);
  }

  async function submitForm() {
    try {
      if (modal?.mode === 'edit' && modal.record?.uuid) {
        await updateMutation.mutateAsync({ uuid: modal.record.uuid, payload: formValue });
        setFeedback({ type: 'success', message: `${resource.label} updated successfully.` });
      } else {
        await createMutation.mutateAsync(formValue);
        setFeedback({ type: 'success', message: `${resource.label} created successfully.` });
      }

      closeModal();
    } catch (error) {
      setFeedback({ type: 'error', message: readErrorMessage(error) });
    }
  }

  async function deleteRecord(record: MasterDataRecord) {
    if (!record.uuid) {
      setFeedback({ type: 'error', message: 'Record UUID is missing.' });
      return;
    }

    const name = stringifyCell(record[resource.nameKey] ?? record[resource.codeKey] ?? record.uuid);

    if (!window.confirm(`Delete ${name}? This will use the Master Data delete API.`)) {
      return;
    }

    try {
      await deleteMutation.mutateAsync(record.uuid);
      setFeedback({ type: 'success', message: `${resource.label} deleted successfully.` });
    } catch (error) {
      setFeedback({ type: 'error', message: readErrorMessage(error) });
    }
  }

  function updateSearch(value: string) {
    setSearch(value);
    setPage(1);
  }

  return (
    <section className="space-y-5">
      <div className="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
        <div>
          <p className="text-sm font-semibold uppercase tracking-wide text-brand">Master Data</p>
          <h1 className="mt-1 text-2xl font-semibold text-slate-950">Master Data Workspace</h1>
          <p className="mt-2 max-w-3xl text-sm text-slate-600">Manage MVP reference resources through the existing Master Data REST API.</p>
        </div>
        <div className="flex flex-wrap gap-2">
          <button className="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" onClick={() => listQuery.refetch()} type="button">
            <RefreshCw aria-hidden="true" className="h-4 w-4" />
            Refresh
          </button>
          {can(permissions.create) ? (
            <button className="inline-flex items-center gap-2 rounded-md bg-brand px-3 py-2 text-sm font-semibold text-white hover:bg-brand-dark" onClick={() => openModal('create')} type="button">
              <Plus aria-hidden="true" className="h-4 w-4" />
              New Record
            </button>
          ) : null}
        </div>
      </div>

      <div className="grid gap-5 xl:grid-cols-[18rem_minmax(0,1fr)]">
        <aside className="rounded-md border border-slate-200 bg-white p-3">
          <p className="px-2 pb-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Resources</p>
          <div className="space-y-4">
            {(['Organization', 'Production', 'Feed', 'Reference'] as const).map((group) => (
              <div key={group}>
                <p className="px-2 py-1 text-xs font-semibold text-slate-400">{group}</p>
                <div className="space-y-1">
                  {masterDataResources
                    .filter((item) => item.group === group)
                    .map((item) => (
                      <button
                        className={
                          item.key === resource.key
                            ? 'w-full rounded-md bg-brand-soft px-3 py-2 text-left text-sm font-semibold text-brand-dark'
                            : 'w-full rounded-md px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-50'
                        }
                        key={item.key}
                        onClick={() => switchResource(item.key)}
                        type="button"
                      >
                        {item.label}
                      </button>
                    ))}
                </div>
              </div>
            ))}
          </div>
        </aside>

        <div className="space-y-4">
          <div className="rounded-md border border-slate-200 bg-white p-4">
            <div className="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
              <div>
                <h2 className="text-lg font-semibold text-slate-950">{resource.label}</h2>
                <p className="text-sm text-slate-500">{resource.description}</p>
              </div>
              <div className="relative w-full lg:w-80">
                <Search aria-hidden="true" className="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-slate-400" />
                <input className="w-full rounded-md border border-slate-300 py-2 pl-9 pr-3 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand/20" onChange={(event) => updateSearch(event.target.value)} placeholder={`Search ${resource.label}`} type="search" value={search} />
              </div>
            </div>
          </div>

          {feedback ? (
            <div className={feedback.type === 'success' ? 'rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700' : 'rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700'}>{feedback.message}</div>
          ) : null}
          {listQuery.isError ? <div className="rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{readErrorMessage(listQuery.error)}</div> : null}

          <MasterDataTable columns={resource.columns} rows={rows} loading={listQuery.isLoading} resolveValue={resolveLookupLabel} onView={(record) => openModal('view', record)} onEdit={(record) => openModal('edit', record)} onDelete={deleteRecord} canUpdate={can(permissions.update)} canDelete={can(permissions.delete)} />

          <div className="flex flex-col gap-3 rounded-md border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <span>
              Page {currentPage} of {lastPage} {meta ? `- ${meta.total} records` : ''}
            </span>
            <div className="flex gap-2">
              <button className="rounded-md border border-slate-300 px-3 py-2 font-semibold text-slate-700 disabled:cursor-not-allowed disabled:opacity-50" disabled={currentPage <= 1} onClick={() => setPage((value) => Math.max(1, value - 1))} type="button">
                Previous
              </button>
              <button className="rounded-md border border-slate-300 px-3 py-2 font-semibold text-slate-700 disabled:cursor-not-allowed disabled:opacity-50" disabled={currentPage >= lastPage} onClick={() => setPage((value) => Math.min(lastPage, value + 1))} type="button">
                Next
              </button>
            </div>
          </div>
        </div>
      </div>

      <MasterDataFormModal
        error={modal && mutationError ? readErrorMessage(mutationError) : undefined}
        fields={resource.fields}
        loading={busy}
        lookupOptions={lookupOptions}
        mode={modal?.mode ?? 'view'}
        onChange={(key, value) => setFormValue((current) => ({ ...current, [key]: value }))}
        onClose={closeModal}
        onSubmit={submitForm}
        open={Boolean(modal)}
        title={`${modal?.mode === 'create' ? 'Create' : modal?.mode === 'edit' ? 'Edit' : 'View'} ${resource.label}`}
        value={formValue}
      />
    </section>
  );
}
