import { Edit, Eye, Trash2 } from 'lucide-react';
import type { MasterDataColumnConfig, MasterDataRecord } from '../types/masterData';

type MasterDataTableProps = {
  columns: MasterDataColumnConfig[];
  rows: MasterDataRecord[];
  loading: boolean;
  resolveValue: (row: MasterDataRecord, column: MasterDataColumnConfig) => string;
  onView: (record: MasterDataRecord) => void;
  onEdit: (record: MasterDataRecord) => void;
  onDelete: (record: MasterDataRecord) => void;
  canUpdate: boolean;
  canDelete: boolean;
};

export function MasterDataTable({ columns, rows, loading, resolveValue, onView, onEdit, onDelete, canUpdate, canDelete }: MasterDataTableProps) {
  if (loading) {
    return (
      <div className="overflow-hidden rounded-md border border-slate-200 bg-white">
        <div className="space-y-3 p-4">
          {Array.from({ length: 5 }).map((_, index) => (
            <div className="h-10 animate-pulse rounded-md bg-slate-100" key={index} />
          ))}
        </div>
      </div>
    );
  }

  if (rows.length === 0) {
    return (
      <div className="rounded-md border border-dashed border-slate-300 bg-white p-8 text-center">
        <p className="text-sm font-semibold text-slate-800">No records found</p>
        <p className="mt-1 text-sm text-slate-500">Try changing the search keyword or refresh the resource.</p>
      </div>
    );
  }

  return (
    <div className="overflow-hidden rounded-md border border-slate-200 bg-white">
      <div className="overflow-x-auto">
        <table className="min-w-full divide-y divide-slate-200 text-sm">
          <thead className="bg-slate-50">
            <tr>
              {columns.map((column) => (
                <th className="whitespace-nowrap px-4 py-3 text-left font-semibold text-slate-600" key={column.key}>
                  {column.label}
                </th>
              ))}
              <th className="w-32 px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-slate-100">
            {rows.map((row) => (
              <tr className="hover:bg-slate-50" key={String(row.uuid ?? row.id)}>
                {columns.map((column) => (
                  <td className="whitespace-nowrap px-4 py-3 text-slate-700" key={column.key}>
                    {resolveValue(row, column)}
                  </td>
                ))}
                <td className="px-4 py-3">
                  <div className="flex justify-end gap-1">
                    <button className="rounded-md p-2 text-slate-600 hover:bg-slate-100" onClick={() => onView(row)} title="View" type="button">
                      <Eye aria-hidden="true" className="h-4 w-4" />
                    </button>
                    {canUpdate ? (
                      <button className="rounded-md p-2 text-slate-600 hover:bg-slate-100" onClick={() => onEdit(row)} title="Edit" type="button">
                        <Edit aria-hidden="true" className="h-4 w-4" />
                      </button>
                    ) : null}
                    {canDelete ? (
                      <button className="rounded-md p-2 text-red-600 hover:bg-red-50" onClick={() => onDelete(row)} title="Delete" type="button">
                        <Trash2 aria-hidden="true" className="h-4 w-4" />
                      </button>
                    ) : null}
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
