<?php

namespace Activities\Repositories;

use Activities\Models\ActivityType;

final class ActivityTypeRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(ActivityType $model)
    {
        parent::__construct($model);
    }
}