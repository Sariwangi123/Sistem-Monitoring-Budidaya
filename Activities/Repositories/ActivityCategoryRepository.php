<?php

namespace Activities\Repositories;

use Activities\Models\ActivityCategory;

final class ActivityCategoryRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(ActivityCategory $model)
    {
        parent::__construct($model);
    }
}