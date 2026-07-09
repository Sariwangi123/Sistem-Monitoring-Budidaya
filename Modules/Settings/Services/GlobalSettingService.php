<?php

namespace Modules\Settings\Services;

use Core\Contracts\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Logging\AuditLogger;
use Modules\Settings\Repositories\GlobalSettingRepository;

final class GlobalSettingService implements ServiceInterface
{
    public function __construct(
        private readonly GlobalSettingRepository $settings,
        private readonly AuditLogger $auditLogger,
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->settings->paginate($filters, $perPage);
    }

    public function detail(string $id): Model
    {
        return $this->settings->find($id) ?? abort(404, 'Setting not found.');
    }

    public function store(array $payload): Model
    {
        $setting = $this->settings->create($payload);
        $this->auditLogger->record('setting.created', ['target_id' => $setting->getKey()]);

        return $setting;
    }

    public function change(string $id, array $payload): Model
    {
        $setting = $this->settings->update($id, $payload);
        $this->auditLogger->record('setting.updated', ['target_id' => $setting->getKey()]);

        return $setting;
    }

    public function remove(string $id): void
    {
        $this->settings->delete($id);
        $this->auditLogger->record('setting.deleted', ['target_id' => $id]);
    }
}
