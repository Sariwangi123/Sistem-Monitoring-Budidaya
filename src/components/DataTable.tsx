type DataTableProps<T> = {
  columns: Array<keyof T>;
  rows: T[];
};

export function DataTable<T extends Record<string, string | number | boolean>>({ columns, rows }: DataTableProps<T>) {
  return (
    <div className="overflow-hidden rounded-md border border-slate-200">
      <table className="min-w-full divide-y divide-slate-200 text-sm">
        <thead className="bg-slate-50">
          <tr>
            {columns.map((column) => (
              <th key={String(column)} className="px-4 py-3 text-left font-semibold text-slate-600">
                {String(column)}
              </th>
            ))}
          </tr>
        </thead>
        <tbody className="divide-y divide-slate-100 bg-white">
          {rows.map((row, index) => (
            <tr key={index}>
              {columns.map((column) => (
                <td key={String(column)} className="px-4 py-3 text-slate-700">
                  {String(row[column])}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
