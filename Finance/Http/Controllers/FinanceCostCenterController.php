<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceCostCenterRequest;
use Finance\Http\Resources\FinanceCostCenterResource;
use Finance\Services\FinanceCostCenterService;
use MasterData\Http\Controllers\BaseController;

final class FinanceCostCenterController extends BaseController
{
    public function __construct(FinanceCostCenterService $service)
    {
        parent::__construct($service, FinanceCostCenterResource::class, FinanceCostCenterRequest::class);
    }
}
