<?php

namespace Harvest\Http\Controllers;

use MasterData\Http\Controllers\BaseController;
use Harvest\Http\Requests\HarvestDeliveryRequest;
use Harvest\Http\Resources\HarvestDeliveryResource;
use Harvest\Services\HarvestDeliveryService;

class HarvestDeliveryController extends BaseController
{
    public function __construct(HarvestDeliveryService $service)
    {
        parent::__construct($service, HarvestDeliveryResource::class, HarvestDeliveryRequest::class);
    }
}