<?php

namespace Finance\Repositories;

use Finance\Models\FinanceJournalEntry;
use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceJournalEntryRepository extends BaseRepository implements FinanceJournalEntryRepositoryInterface
{
    public function __construct(FinanceJournalEntry $model)
    {
        parent::__construct($model);
    }
}
