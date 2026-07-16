import { Save, X } from 'lucide-react';
import type { FormEvent } from 'react';
import type { MasterDataFieldConfig, MasterDataModalMode, MasterDataPayload, MasterDataRecord } from '../types/masterData';

type LookupOptions = Record<string, MasterDataRecord[]>;

type MasterDataFormModalProps = {
  open: boolean;
  mode: MasterDataModalMode;
  title: string;
  fields: MasterDataFieldConfig[];
  value: MasterDataPayload;
  lookupOptions: LookupOptions;
  loading: boolean;
  error?: string;
  onChange: (key: string, value: string | number | null) => void;
  onClose: () => void;
  onSubmit: () => void;
};

function readLookupLabel(option: MasterDataRecord, field: MasterDataFieldConfig) {
  const label = field.lookupLabelKey ? option[field.lookupLabelKey] : undefined;

  return String(label ?? option.name ?? option.label ?? option.uuid ?? option.id ?? 'Option');
}

export function MasterDataFormModal({ open, mode, title, fields, value, lookupOptions, loading, error, onChange, onClose, onSubmit }: MasterDataFormModalProps) {
  if (!open) {
    return null;
  }

  const readOnly = mode === 'view';

  function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault();

    if (!readOnly) {
      onSubmit();
    }
  }

  return (
    <div className="fixed inset-0 z-50 grid place-items-center bg-slate-950/40 p-4">
      <form className="max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-md bg-white shadow-xl" onSubmit={handleSubmit}>
        <div className="flex items-center justify-between border-b border-slate-200 px-5 py-4">
          <div>
            <h2 className="text-base font-semibold text-slate-900">{title}</h2>
            <p className="text-sm text-slate-500">{readOnly ? 'Read-only record detail' : 'Fields marked with * are required'}</p>
          </div>
          <button className="rounded-md p-2 text-slate-500 hover:bg-slate-100" onClick={onClose} title="Close" type="button">
            <X aria-hidden="true" className="h-4 w-4" />
          </button>
        </div>

        <div className="max-h-[65vh] overflow-y-auto px-5 py-4">
          {error ? <div className="mb-4 rounded-md border border-red-200 bg-red-50 px-3 py-2 text-sm text-red-700">{error}</div> : null}
          <div className="grid gap-4 md:grid-cols-2">
            {fields.map((field) => {
              const fieldValue = value[field.key] ?? '';
              const className =
                'w-full rounded-md border border-slate-300 px-3 py-2 text-sm text-slate-900 outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 disabled:bg-slate-100 disabled:text-slate-500';
              const wrapperClassName = field.gridSpan === 'full' ? 'md:col-span-2' : '';

              return (
                <label className={wrapperClassName} key={field.key}>
                  <span className="mb-1 block text-sm font-medium text-slate-700">
                    {field.label}
                    {field.required ? <span className="text-red-600"> *</span> : null}
                  </span>
                  {field.type === 'textarea' ? (
                    <textarea
                      className={`${className} min-h-24 resize-y`}
                      disabled={readOnly}
                      onChange={(event) => onChange(field.key, event.target.value || null)}
                      placeholder={field.placeholder}
                      value={String(fieldValue)}
                    />
                  ) : field.type === 'select' && field.lookupResource ? (
                    <select className={className} disabled={readOnly} onChange={(event) => onChange(field.key, event.target.value ? Number(event.target.value) : null)} value={String(fieldValue)}>
                      <option value="">Select {field.label}</option>
                      {(lookupOptions[field.lookupResource] ?? []).map((option) => (
                        <option key={String(option.id ?? option.uuid)} value={String(option.id ?? '')}>
                          {readLookupLabel(option, field)}
                        </option>
                      ))}
                    </select>
                  ) : (
                    <input
                      className={className}
                      disabled={readOnly}
                      onChange={(event) => onChange(field.key, field.type === 'number' ? (event.target.value ? Number(event.target.value) : null) : event.target.value || null)}
                      placeholder={field.placeholder}
                      type={field.type ?? 'text'}
                      value={String(fieldValue)}
                    />
                  )}
                </label>
              );
            })}
          </div>
        </div>

        <div className="flex justify-end gap-2 border-t border-slate-200 px-5 py-4">
          <button className="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50" onClick={onClose} type="button">
            {readOnly ? 'Close' : 'Cancel'}
          </button>
          {!readOnly ? (
            <button className="inline-flex items-center gap-2 rounded-md bg-brand px-4 py-2 text-sm font-semibold text-white hover:bg-brand-dark disabled:cursor-not-allowed disabled:bg-slate-300" disabled={loading} type="submit">
              <Save aria-hidden="true" className="h-4 w-4" />
              {loading ? 'Saving...' : 'Save'}
            </button>
          ) : null}
        </div>
      </form>
    </div>
  );
}
