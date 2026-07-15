<?php

namespace Finance\Services;

use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceJournalEntryService extends BaseService
{
    public function __construct(FinanceJournalEntryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        return DB::transaction(fn (): object => parent::update($id, $data));
    }
}