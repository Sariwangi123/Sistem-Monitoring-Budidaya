<?php

namespace Finance\Services;

use Finance\Exceptions\FinancialPeriodClosedException;
use Finance\Exceptions\InvalidCostCenterException;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceFinancialSummary;
use Finance\Repositories\Contracts\FinanceJournalRepositoryInterface;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceJournalService extends BaseService
{
    private FinanceLedgerRepositoryInterface $ledgerRepository;
    private FinanceJournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(
        FinanceJournalRepositoryInterface $repository,
        FinanceLedgerRepositoryInterface $ledgerRepository,
        FinanceJournalEntryRepositoryInterface $journalEntryRepository
    ) {
        parent::__construct($repository);
        $this->ledgerRepository = $ledgerRepository;
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function create(array $data): object
    {
        $this->validateJournalDate($data['journal_date'] ?? null);

        if (empty($data['journal_number'])) {
            $data['journal_number'] = 'JRN-' . strtoupper(uniqid());
        }
        if (empty($data['document_number'])) {
            $data['document_number'] = 'DOC-JRN-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $journal = $this->findById($id);
        $this->ensureEditable($journal);

        if (isset($data['journal_date'])) {
            $this->validateJournalDate($data['journal_date']);
        }

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function postJournal(int|string $id): object
    {
        return DB::transaction(function () use ($id): object {
            $journal = $this->findById($id);

            if (! $journal) {
                throw new \InvalidArgumentException('Journal not found.');
            }

            if (! in_array((string) $journal->status, ['Draft', 'Validated'], true)) {
                throw new \InvalidArgumentException("Journal status '{$journal->status}' cannot transition to 'Posted'.");
            }

            $this->validateJournalDate($journal->journal_date);

            $entries = $journal->entries;
            if ($entries->isEmpty()) {
                throw new \InvalidArgumentException('Cannot post journal with no entries.');
            }

            $totalDebit = 0;
            $totalCredit = 0;

            foreach ($entries as $entry) {
                $totalDebit += $entry->debit_amount;
                $totalCredit += $entry->credit_amount;

                // Validate cost center for each entry
                if ($entry->cost_center_id) {
                    $costCenter = FinanceCostCenter::find($entry->cost_center_id);
                    if (!$costCenter || $costCenter->status !== 'Active') {
                        throw new InvalidCostCenterException("Cost center associated with entry is inactive or invalid.");
                    }
                }
            }

            // Check if debit equals credit
            if (abs($totalDebit - $totalCredit) > 0.001) {
                throw new \InvalidArgumentException('Journal is not balanced. Total Debit must equal Total Credit.');
            }

            // Create ledger entry for each journal entry
            foreach ($entries as $entry) {
                $ledger = $this->ledgerRepository->create([
                    'company_id' => $journal->company_id,
                    'farm_id' => $journal->farm_id,
                    'culture_cycle_id' => null,
                    'cost_center_id' => $entry->cost_center_id,
                    'journal_id' => $journal->id,
                    'ledger_number' => 'LDG-' . strtoupper(uniqid()),
                    'document_number' => $journal->document_number ?: ('DOC-JRN-' . strtoupper(uniqid())),
                    'ledger_date' => $journal->journal_date,
                    'ledger_type' => $journal->journal_type ?: 'Operational',
                    'account_code' => $entry->account_code,
                    'account_name' => $entry->account_name,
                    'debit_amount' => $entry->debit_amount,
                    'credit_amount' => $entry->credit_amount,
                    'balance_amount' => $entry->debit_amount - $entry->credit_amount,
                    'currency' => 'IDR',
                    'source_type' => 'FinanceJournalEntry',
                    'source_uuid' => $entry->uuid,
                    'posted_at' => now(),
                    'status' => 'Posted',
                    'description' => $entry->description ?: $journal->description,
                ]);

                $this->journalEntryRepository->update($entry->id, [
                    'ledger_id' => $ledger->id,
                ]);
            }

            return parent::update($id, [
                'status' => 'Posted',
                'total_debit' => $totalDebit,
                'total_credit' => $totalCredit,
            ]);
        });
    }

    private function ensureEditable(?object $journal): void
    {
        if (! $journal) {
            throw new \InvalidArgumentException('Journal not found.');
        }

        if (in_array((string) $journal->status, ['Posted', 'Completed', 'Closed', 'Locked'], true)) {
            throw new \InvalidArgumentException('Posted journal cannot be changed.');
        }
    }

    private function validateJournalDate($date): void
    {
        if ($date) {
            $dateStr = $date instanceof \DateTimeInterface ? $date->format('Y-m-d') : (string) $date;
            // Check closed financial period
            $closedSummaryExists = FinanceFinancialSummary::query()
                ->where('period_start', '<=', $dateStr)
                ->where('period_end', '>=', $dateStr)
                ->whereIn('status', ['Closed', 'Locked'])
                ->exists();

            if ($closedSummaryExists) {
                throw new FinancialPeriodClosedException("The financial period for date {$dateStr} is closed or locked.");
            }
        }
    }
}