<?php

namespace Activities\Repositories;

use Activities\Models\Activity;

final class ActivityRepository extends \MasterData\Repositories\BaseRepository
{
    public function __construct(Activity $model)
    {
        parent::__construct($model);
    }
}