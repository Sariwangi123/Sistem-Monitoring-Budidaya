type ChartPlaceholderProps = {
  label: string;
  value: number;
};

export function ChartPlaceholder({ label, value }: ChartPlaceholderProps) {
  return (
    <div className="h-48 rounded-md border border-slate-200 bg-white p-4">
      <div className="flex h-full flex-col justify-end gap-3">
        <div className="rounded bg-brand" style={{ height: `${Math.max(8, Math.min(value, 100))}%` }} />
        <p className="text-sm font-medium text-slate-700">{label}</p>
      </div>
    </div>
  );
}
