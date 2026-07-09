<?php

namespace Modules\Notifications\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Persistence\EloquentRepository;
use Modules\Notifications\Models\NotificationTemplate;

final class NotificationTemplateRepository extends EloquentRepository
{
    public function __construct(NotificationTemplate $template)
    {
        parent::__construct($template);
    }

    protected function applySearch(Builder $query, string $search): void
    {
        $query->where('name', 'like', "%{$search}%")
            ->orWhere('channel', 'like', "%{$search}%");
    }
}
