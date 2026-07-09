<?php

namespace Modules\Settings\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Infrastructure\Persistence\EloquentRepository;
use Modules\Settings\Models\GlobalSetting;

final class GlobalSettingRepository extends EloquentRepository
{
    public function __construct(GlobalSetting $setting)
    {
        parent::__construct($setting);
    }

    protected function applySearch(Builder $query, string $search): void
    {
        $query->where('key', 'like', "%{$search}%");
    }
}
