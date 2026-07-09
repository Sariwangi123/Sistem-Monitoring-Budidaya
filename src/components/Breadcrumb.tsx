type BreadcrumbProps = {
  items: string[];
};

export function Breadcrumb({ items }: BreadcrumbProps) {
  return (
    <nav aria-label="Breadcrumb" className="text-sm text-slate-500">
      {items.join(' / ')}
    </nav>
  );
}
