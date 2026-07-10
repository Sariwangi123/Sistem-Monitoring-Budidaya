<?php

namespace Activities\Http\Controllers;

use Activities\Http\Requests\ActivityCategoryRequest;
use Activities\Http\Resources\ActivityCategoryResource;
use Activities\Services\ActivityCategoryService;
use MasterData\Http\Controllers\BaseController;

final class ActivityCategoryController extends BaseController
{
    public function __construct(ActivityCategoryService $service)
    {
        parent::__construct($service, ActivityCategoryResource::class, ActivityCategoryRequest::class);
    }
}
