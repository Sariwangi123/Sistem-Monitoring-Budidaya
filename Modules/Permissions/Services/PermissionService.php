<?php

namespace Modules\Permissions\Services;

use Core\Contracts\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Logging\AuditLogger;
use Modules\Permissions\Repositories\PermissionRepository;

final class PermissionService implements ServiceInterface
{
    public function __construct(
        private readonly PermissionRepository $permissions,
        private readonly AuditLogger $auditLogger,
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->permissions->paginate($filters, $perPage);
    }

    public function detail(string $id): Model
    {
        return $this->permissions->find($id) ?? abort(404, 'Permission not found.');
    }

    public function store(array $payload): Model
    {
        $permission = $this->permissions->create($payload);
        $this->auditLogger->record('permission.created', ['target_id' => $permission->getKey()]);

        return $permission;
    }

    public function change(string $id, array $payload): Model
    {
        $permission = $this->permissions->update($id, $payload);
        $this->auditLogger->record('permission.updated', ['target_id' => $permission->getKey()]);

        return $permission;
    }

    public function remove(string $id): void
    {
        $this->permissions->delete($id);
        $this->auditLogger->record('permission.deleted', ['target_id' => $id]);
    }
}
