<?php

namespace Modules\Notifications\Services;

use Core\Contracts\ServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Infrastructure\Logging\AuditLogger;
use Modules\Notifications\Repositories\NotificationTemplateRepository;

final class NotificationTemplateService implements ServiceInterface
{
    public function __construct(
        private readonly NotificationTemplateRepository $templates,
        private readonly AuditLogger $auditLogger,
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->templates->paginate($filters, $perPage);
    }

    public function detail(string $id): Model
    {
        return $this->templates->find($id) ?? abort(404, 'Notification template not found.');
    }

    public function store(array $payload): Model
    {
        $template = $this->templates->create($payload);
        $this->auditLogger->record('notification_template.created', ['target_id' => $template->getKey()]);

        return $template;
    }

    public function change(string $id, array $payload): Model
    {
        $template = $this->templates->update($id, $payload);
        $this->auditLogger->record('notification_template.updated', ['target_id' => $template->getKey()]);

        return $template;
    }

    public function remove(string $id): void
    {
        $this->templates->delete($id);
        $this->auditLogger->record('notification_template.deleted', ['target_id' => $id]);
    }
}
