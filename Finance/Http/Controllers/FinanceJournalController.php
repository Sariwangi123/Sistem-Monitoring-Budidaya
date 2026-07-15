<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceJournalRequest;
use Finance\Http\Resources\FinanceJournalResource;
use Finance\Services\FinanceJournalService;
use MasterData\Http\Controllers\BaseController;

final class FinanceJournalController extends BaseController
{
    public function __construct(FinanceJournalService $service)
    {
        parent::__construct($service, FinanceJournalResource::class, FinanceJournalRequest::class);
    }
}
