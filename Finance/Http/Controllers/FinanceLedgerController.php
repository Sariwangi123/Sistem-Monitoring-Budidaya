<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceLedgerRequest;
use Finance\Http\Resources\FinanceLedgerResource;
use Finance\Services\FinanceLedgerService;
use MasterData\Http\Controllers\BaseController;

final class FinanceLedgerController extends BaseController
{
    public function __construct(FinanceLedgerService $service)
    {
        parent::__construct($service, FinanceLedgerResource::class, FinanceLedgerRequest::class);
    }
}
