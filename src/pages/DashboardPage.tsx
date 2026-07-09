import { Breadcrumb } from '../components/Breadcrumb';
import { Card } from '../components/Card';
import { DataTable } from '../components/DataTable';

const rows = [
  { module: 'Authentication', status: 'Ready', owner: 'Foundation' },
  { module: 'Authorization', status: 'Ready', owner: 'Foundation' },
  { module: 'User Management', status: 'Ready', owner: 'Foundation' },
  { module: 'Global Configuration', status: 'Ready', owner: 'Foundation' },
];

export function DashboardPage() {
  return (
    <div className="space-y-6">
      <div className="space-y-2">
        <Breadcrumb items={['UtiFarm', 'Foundation']} />
        <h1 className="text-2xl font-semibold text-slate-950">Foundation Dashboard</h1>
      </div>
      <div className="grid gap-4 md:grid-cols-3">
        <Card title="API Standard">
          <p className="text-2xl font-semibold text-brand-dark">REST v1</p>
        </Card>
        <Card title="Authorization">
          <p className="text-2xl font-semibold text-brand-dark">RBAC</p>
        </Card>
        <Card title="Testing">
          <p className="text-2xl font-semibold text-brand-dark">80%</p>
        </Card>
      </div>
      <Card title="Foundation Modules">
        <DataTable columns={['module', 'status', 'owner']} rows={rows} />
      </Card>
    </div>
  );
}
