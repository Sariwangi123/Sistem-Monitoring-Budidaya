<?php

namespace Finance\Services;

use Finance\Exceptions\LedgerAlreadyPostedException;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceLedgerService extends BaseService
{
    public function __construct(FinanceLedgerRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        if (empty($data['ledger_number'])) {
            $data['ledger_number'] = 'LDG-' . strtoupper(uniqid());
        }
        if (empty($data['document_number'])) {
            $data['document_number'] = 'DOC-LDG-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $ledger = $this->findById($id);
        if ($ledger && (string) $ledger->status === 'Posted') {
            throw new LedgerAlreadyPostedException('Posted ledger cannot be changed.');
        }

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function delete(int|string $id): bool
    {
        $ledger = $this->findById($id);
        if ($ledger && (string) $ledger->status === 'Posted') {
            throw new LedgerAlreadyPostedException('Posted ledger cannot be deleted.');
        }

        return DB::transaction(fn (): bool => parent::delete($id));
    }
}