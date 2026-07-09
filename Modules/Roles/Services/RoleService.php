<?php

namespace Modules\Roles\Services;

use Core\Contracts\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Logging\AuditLogger;
use Modules\Roles\Repositories\RoleRepository;

final class RoleService implements ServiceInterface
{
    public function __construct(
        private readonly RoleRepository $roles,
        private readonly AuditLogger $auditLogger,
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->roles->paginate($filters, $perPage);
    }

    public function detail(string $id): Model
    {
        return $this->roles->find($id) ?? abort(404, 'Role not found.');
    }

    public function store(array $payload): Model
    {
        $role = $this->roles->create($payload);
        $this->auditLogger->record('role.created', ['target_id' => $role->getKey()]);

        return $role;
    }

    public function change(string $id, array $payload): Model
    {
        $role = $this->roles->update($id, $payload);
        $this->auditLogger->record('role.updated', ['target_id' => $role->getKey()]);

        return $role;
    }

    public function remove(string $id): void
    {
        $this->roles->delete($id);
        $this->auditLogger->record('role.deleted', ['target_id' => $id]);
    }

    public function assignPermissions(string $id, array $permissionIds): Model
    {
        $role = $this->detail($id);
        $role->permissions()->sync($permissionIds);
        $this->auditLogger->record('role.permissions_assigned', [
            'target_id' => $id,
            'permission_ids' => $permissionIds,
        ]);

        return $role->load('permissions');
    }
}
