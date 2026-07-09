<?php

namespace Modules\Users\Services;

use Core\Contracts\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Logging\AuditLogger;
use Modules\Users\Repositories\UserRepository;

final class UserService implements ServiceInterface
{
    public function __construct(
        private readonly UserRepository $users,
        private readonly AuditLogger $auditLogger,
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->users->paginate($filters, $perPage);
    }

    public function detail(string $id): Model
    {
        return $this->users->find($id) ?? abort(404, 'User not found.');
    }

    public function store(array $payload): Model
    {
        $payload['password'] = Hash::make($payload['password']);
        $user = $this->users->create($payload);
        $this->auditLogger->record('user.created', ['target_id' => $user->getKey()]);

        return $user;
    }

    public function change(string $id, array $payload): Model
    {
        if (! empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            unset($payload['password']);
        }

        $user = $this->users->update($id, $payload);
        $this->auditLogger->record('user.updated', ['target_id' => $user->getKey()]);

        return $user;
    }

    public function remove(string $id): void
    {
        $this->users->delete($id);
        $this->auditLogger->record('user.deleted', ['target_id' => $id]);
    }

    public function assignRoles(string $id, array $roleIds): Model
    {
        $user = $this->detail($id);
        $user->roles()->sync($roleIds);
        $this->auditLogger->record('user.roles_assigned', ['target_id' => $id, 'role_ids' => $roleIds]);

        return $user->load('roles');
    }
}
