<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceJournalEntryRequest;
use Finance\Http\Resources\FinanceJournalEntryResource;
use Finance\Services\FinanceJournalEntryService;
use MasterData\Http\Controllers\BaseController;

final class FinanceJournalEntryController extends BaseController
{
    public function __construct(FinanceJournalEntryService $service)
    {
        parent::__construct($service, FinanceJournalEntryResource::class, FinanceJournalEntryRequest::class);
    }
}
