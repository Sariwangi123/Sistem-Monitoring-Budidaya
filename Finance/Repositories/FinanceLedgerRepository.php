<?php

namespace Finance\Repositories;

use Finance\Models\FinanceLedger;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceLedgerRepository extends BaseRepository implements FinanceLedgerRepositoryInterface
{
    public function __construct(FinanceLedger $model)
    {
        parent::__construct($model);
    }
}
