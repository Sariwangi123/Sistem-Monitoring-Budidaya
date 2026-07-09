import type { InputHTMLAttributes } from 'react';

type FormFieldProps = InputHTMLAttributes<HTMLInputElement> & {
  label: string;
};

export function FormField({ label, id, ...props }: FormFieldProps) {
  const inputId = id ?? label.toLowerCase().replaceAll(' ', '-');

  return (
    <label className="block text-sm font-medium text-slate-700" htmlFor={inputId}>
      {label}
      <input
        id={inputId}
        className="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm outline-none focus:border-brand focus:ring-2 focus:ring-brand-soft"
        {...props}
      />
    </label>
  );
}
