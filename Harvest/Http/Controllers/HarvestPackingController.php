<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestPackingRequest;
use Harvest\Http\Resources\HarvestPackingResource;
use Harvest\Services\HarvestPackingService;

class HarvestPackingController extends BaseController
{
    public function __construct(HarvestPackingService $service)
    {
        parent::__construct($service, HarvestPackingResource::class, HarvestPackingRequest::class);
    }
}