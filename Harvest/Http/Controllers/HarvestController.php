<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestRequest;
use Harvest\Http\Resources\HarvestResource;
use Harvest\Services\HarvestService;

class HarvestController extends BaseController
{
    public function __construct(HarvestService $service)
    {
        parent::__construct($service, HarvestResource::class, HarvestRequest::class);
    }
}