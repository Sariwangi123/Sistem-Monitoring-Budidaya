<?php

namespace Activities\Services;

use Activities\Repositories\ActivityRepository;

final class ActivityService extends \MasterData\Services\BaseService
{
    public function __construct(ActivityRepository $repository)
    {
        parent::__construct($repository);
    }
}