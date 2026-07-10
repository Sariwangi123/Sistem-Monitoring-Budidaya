<?php

namespace Activities\Services;

use Activities\Repositories\ActivityTypeRepository;
use MasterData\Services\BaseService;

final class ActivityTypeService extends BaseService
{
    public function __construct(ActivityTypeRepository $repository)
    {
        parent::__construct($repository);
    }
}
