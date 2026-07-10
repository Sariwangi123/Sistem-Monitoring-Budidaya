<?php

namespace Activities\Services;

use Activities\Repositories\ActivityCategoryRepository;
use MasterData\Services\BaseService;

final class ActivityCategoryService extends BaseService
{
    public function __construct(ActivityCategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}
