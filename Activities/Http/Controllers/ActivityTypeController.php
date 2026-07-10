<?php

namespace Activities\Http\Controllers;

use Activities\Http\Requests\ActivityTypeRequest;
use Activities\Http\Resources\ActivityTypeResource;
use Activities\Services\ActivityTypeService;
use MasterData\Http\Controllers\BaseController;

final class ActivityTypeController extends BaseController
{
    public function __construct(ActivityTypeService $service)
    {
        parent::__construct($service, ActivityTypeResource::class, ActivityTypeRequest::class);
    }
}
