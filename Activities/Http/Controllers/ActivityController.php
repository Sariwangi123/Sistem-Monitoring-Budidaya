<?php

namespace Activities\Http\Controllers;

use Activities\Http\Requests\ActivityRequest;
use Activities\Http\Resources\ActivityResource;
use Activities\Services\ActivityService;
use MasterData\Http\Controllers\BaseController;

final class ActivityController extends BaseController
{
    public function __construct(ActivityService $service)
    {
        parent::__construct($service, ActivityResource::class, ActivityRequest::class);
    }
}