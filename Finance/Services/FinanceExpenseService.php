<?php

namespace Finance\Services;

use Finance\Exceptions\FinancialPeriodClosedException;
use Finance\Exceptions\InvalidCostCenterException;
use Finance\Exceptions\InvalidCostObjectException;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceFinancialSummary;
use Finance\Repositories\Contracts\FinanceExpenseRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalRepositoryInterface;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceExpenseService extends BaseService
{
    private FinanceJournalRepositoryInterface $journalRepository;
    private FinanceLedgerRepositoryInterface $ledgerRepository;
    private FinanceJournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(
        FinanceExpenseRepositoryInterface $repository,
        FinanceJournalRepositoryInterface $journalRepository,
        FinanceLedgerRepositoryInterface $ledgerRepository,
        FinanceJournalEntryRepositoryInterface $journalEntryRepository
    ) {
        parent::__construct($repository);
        $this->journalRepository = $journalRepository;
        $this->ledgerRepository = $ledgerRepository;
        $this->journalEntryRepository = $journalEntryRepository;
    }

    public function create(array $data): object
    {
        $this->validateExpense($data);

        if (empty($data['expense_number'])) {
            $data['expense_number'] = 'EXP-' . strtoupper(uniqid());
        }
        if (empty($data['document_number'])) {
            $data['document_number'] = 'DOC-EXP-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $expense = $this->findById($id);

        $this->ensureEditable($expense);

        $mergedData = array_merge($expense->toArray(), $data);
        $this->validateExpense($mergedData);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function postExpense(int|string $id): object
    {
        return DB::transaction(function () use ($id): object {
            $expense = $this->findById($id);

            if (! $expense) {
                throw new \InvalidArgumentException('Expense not found.');
            }

            if (! in_array((string) $expense->status, ['Draft', 'Validated'], true)) {
                throw new \InvalidArgumentException("Expense status '{$expense->status}' cannot transition to 'Posted'.");
            }

            $this->validateExpense($expense->toArray());

            // Create Journal
            $journal = $this->journalRepository->create([
                'company_id' => $expense->company_id,
                'farm_id' => $expense->farm_id,
                'user_id' => $expense->user_id,
                'journal_number' => 'JRN-' . strtoupper(uniqid()),
                'document_number' => $expense->document_number ?: ('DOC-EXP-' . strtoupper(uniqid())),
                'journal_date' => $expense->expense_date,
                'journal_type' => 'Expense',
                'total_debit' => $expense->total_amount,
                'total_credit' => $expense->total_amount,
                'source_type' => 'FinanceExpense',
                'source_uuid' => $expense->uuid,
                'status' => 'Posted',
                'description' => $expense->notes ?: 'Auto-generated journal from posted expense',
            ]);

            // Create Ledger
            $ledger = $this->ledgerRepository->create([
                'company_id' => $expense->company_id,
                'farm_id' => $expense->farm_id,
                'culture_cycle_id' => $expense->culture_cycle_id,
                'cost_center_id' => $expense->cost_center_id,
                'expense_id' => $expense->id,
                'journal_id' => $journal->id,
                'ledger_number' => 'LDG-' . strtoupper(uniqid()),
                'document_number' => $expense->document_number ?: ('DOC-EXP-' . strtoupper(uniqid())),
                'ledger_date' => $expense->expense_date,
                'ledger_type' => 'Expense',
                'account_code' => '5100',
                'account_name' => $expense->expense_type . ' Cost',
                'debit_amount' => $expense->total_amount,
                'credit_amount' => 0,
                'balance_amount' => $expense->total_amount,
                'currency' => $expense->currency ?: 'IDR',
                'source_type' => 'FinanceExpense',
                'source_uuid' => $expense->uuid,
                'posted_at' => now(),
                'status' => 'Posted',
                'description' => $expense->notes ?: 'Auto-generated ledger from posted expense',
            ]);

            // Create Debit entry
            $this->journalEntryRepository->create([
                'journal_id' => $journal->id,
                'ledger_id' => $ledger->id,
                'cost_center_id' => $expense->cost_center_id,
                'account_code' => '5100',
                'account_name' => $expense->expense_type . ' Cost',
                'entry_type' => 'Debit',
                'debit_amount' => $expense->total_amount,
                'credit_amount' => 0,
                'line_order' => 1,
                'description' => 'Debit entry for expense ' . $expense->expense_number,
            ]);

            // Create Credit entry
            $this->journalEntryRepository->create([
                'journal_id' => $journal->id,
                'ledger_id' => $ledger->id,
                'cost_center_id' => $expense->cost_center_id,
                'account_code' => '1100',
                'account_name' => 'Cash / Bank',
                'entry_type' => 'Credit',
                'debit_amount' => 0,
                'credit_amount' => $expense->total_amount,
                'line_order' => 2,
                'description' => 'Credit entry for expense ' . $expense->expense_number,
            ]);

            return parent::update($id, [
                'status' => 'Posted',
            ]);
        });
    }

    public function completeExpense(int|string $id): object
    {
        return $this->transition($id, ['Posted'], 'Completed');
    }

    public function closeExpense(int|string $id): object
    {
        return $this->transition($id, ['Completed'], 'Closed');
    }

    public function lockExpense(int|string $id): object
    {
        return $this->transition($id, ['Closed'], 'Locked');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $expense = $this->findById($id);

        if (! $expense) {
            throw new \InvalidArgumentException('Expense not found.');
        }

        if (! in_array((string) $expense->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Expense status '{$expense->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, [
            'status' => $nextStatus,
        ]));
    }

    private function ensureEditable(?object $expense): void
    {
        if (! $expense) {
            throw new \InvalidArgumentException('Expense not found.');
        }

        if (in_array((string) $expense->status, ['Posted', 'Completed', 'Closed', 'Locked'], true)) {
            throw new \InvalidArgumentException('Posted expense cannot be changed.');
        }
    }

    private function validateExpense(array $data): void
    {
        $date = $data['expense_date'] ?? null;
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

        $costCenterId = $data['cost_center_id'] ?? null;
        if ($costCenterId && $date) {
            $costCenter = FinanceCostCenter::find($costCenterId);
            if (!$costCenter) {
                throw new InvalidCostCenterException("Cost center not found.");
            }
            if ($costCenter->status !== 'Active') {
                throw new InvalidCostCenterException("Cost center is inactive.");
            }
            if ($costCenter->effective_from) {
                $effFrom = $costCenter->effective_from instanceof \DateTimeInterface 
                    ? $costCenter->effective_from->format('Y-m-d') 
                    : (string) $costCenter->effective_from;
                if ($dateStr < $effFrom) {
                    throw new InvalidCostCenterException("Cost center is not effective yet.");
                }
            }
            if ($costCenter->effective_to) {
                $effTo = $costCenter->effective_to instanceof \DateTimeInterface 
                    ? $costCenter->effective_to->format('Y-m-d') 
                    : (string) $costCenter->effective_to;
                if ($dateStr > $effTo) {
                    throw new InvalidCostCenterException("Cost center is no longer effective.");
                }
            }
        }

        $expenseType = $data['expense_type'] ?? null;
        if ($expenseType) {
            $validCostObjects = [
                'Feed', 'Medicine', 'Vitamin', 'Chemical', 'Labor', 'Electricity', 
                'Fuel', 'Maintenance', 'Equipment', 'Operational', 'Other'
            ];
            if (!in_array($expenseType, $validCostObjects, true)) {
                throw new InvalidCostObjectException("Invalid cost object: {$expenseType}");
            }
        }
    }
}