<?php

namespace Finance\Repositories;

use Finance\Models\FinanceJournal;
use Finance\Repositories\Contracts\FinanceJournalRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceJournalRepository extends BaseRepository implements FinanceJournalRepositoryInterface
{
    public function __construct(FinanceJournal $model)
    {
        parent::__construct($model);
    }
}
