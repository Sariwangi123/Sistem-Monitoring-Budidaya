<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceCostAllocationRequest;
use Finance\Http\Resources\FinanceCostAllocationResource;
use Finance\Services\FinanceCostAllocationService;
use MasterData\Http\Controllers\BaseController;

final class FinanceCostAllocationController extends BaseController
{
    public function __construct(FinanceCostAllocationService $service)
    {
        parent::__construct($service, FinanceCostAllocationResource::class, FinanceCostAllocationRequest::class);
    }
}
