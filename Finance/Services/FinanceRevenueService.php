<?php

namespace Finance\Services;

use Finance\Exceptions\FinancialPeriodClosedException;
use Finance\Exceptions\InvalidCostCenterException;
use Finance\Exceptions\InvalidCostObjectException;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceFinancialSummary;
use Finance\Repositories\Contracts\FinanceRevenueRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalRepositoryInterface;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceRevenueService extends BaseService
{
    private FinanceJournalRepositoryInterface $journalRepository;
    private FinanceLedgerRepositoryInterface $ledgerRepository;
    private FinanceJournalEntryRepositoryInterface $journalEntryRepository;

    public function __construct(
        FinanceRevenueRepositoryInterface $repository,
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
        $this->validateRevenue($data);

        if (empty($data['revenue_number'])) {
            $data['revenue_number'] = 'REV-' . strtoupper(uniqid());
        }
        if (empty($data['document_number'])) {
            $data['document_number'] = 'DOC-REV-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $revenue = $this->findById($id);

        $this->ensureEditable($revenue);

        $mergedData = array_merge($revenue->toArray(), $data);
        $this->validateRevenue($mergedData);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function postRevenue(int|string $id): object
    {
        return DB::transaction(function () use ($id): object {
            $revenue = $this->findById($id);

            if (! $revenue) {
                throw new \InvalidArgumentException('Revenue not found.');
            }

            if (! in_array((string) $revenue->status, ['Draft', 'Validated'], true)) {
                throw new \InvalidArgumentException("Revenue status '{$revenue->status}' cannot transition to 'Posted'.");
            }

            $this->validateRevenue($revenue->toArray());

            // Create Journal
            $journal = $this->journalRepository->create([
                'company_id' => $revenue->company_id,
                'farm_id' => $revenue->farm_id,
                'user_id' => $revenue->user_id,
                'journal_number' => 'JRN-' . strtoupper(uniqid()),
                'document_number' => $revenue->document_number ?: ('DOC-REV-' . strtoupper(uniqid())),
                'journal_date' => $revenue->revenue_date,
                'journal_type' => 'Revenue',
                'total_debit' => $revenue->total_amount,
                'total_credit' => $revenue->total_amount,
                'source_type' => 'FinanceRevenue',
                'source_uuid' => $revenue->uuid,
                'status' => 'Posted',
                'description' => $revenue->notes ?: 'Auto-generated journal from posted revenue',
            ]);

            // Create Ledger
            $ledger = $this->ledgerRepository->create([
                'company_id' => $revenue->company_id,
                'farm_id' => $revenue->farm_id,
                'culture_cycle_id' => $revenue->culture_cycle_id,
                'cost_center_id' => $revenue->cost_center_id,
                'revenue_id' => $revenue->id,
                'journal_id' => $journal->id,
                'ledger_number' => 'LDG-' . strtoupper(uniqid()),
                'document_number' => $revenue->document_number ?: ('DOC-REV-' . strtoupper(uniqid())),
                'ledger_date' => $revenue->revenue_date,
                'ledger_type' => 'Revenue',
                'account_code' => '4100',
                'account_name' => $revenue->revenue_type . ' Revenue',
                'debit_amount' => 0,
                'credit_amount' => $revenue->total_amount,
                'balance_amount' => -$revenue->total_amount,
                'currency' => $revenue->currency ?: 'IDR',
                'source_type' => 'FinanceRevenue',
                'source_uuid' => $revenue->uuid,
                'posted_at' => now(),
                'status' => 'Posted',
                'description' => $revenue->notes ?: 'Auto-generated ledger from posted revenue',
            ]);

            // Create Debit entry (Cash / Bank)
            $this->journalEntryRepository->create([
                'journal_id' => $journal->id,
                'ledger_id' => $ledger->id,
                'cost_center_id' => $revenue->cost_center_id,
                'account_code' => '1100',
                'account_name' => 'Cash / Bank',
                'entry_type' => 'Debit',
                'debit_amount' => $revenue->total_amount,
                'credit_amount' => 0,
                'line_order' => 1,
                'description' => 'Debit entry for revenue ' . $revenue->revenue_number,
            ]);

            // Create Credit entry (Revenue Account)
            $this->journalEntryRepository->create([
                'journal_id' => $journal->id,
                'ledger_id' => $ledger->id,
                'cost_center_id' => $revenue->cost_center_id,
                'account_code' => '4100',
                'account_name' => $revenue->revenue_type . ' Revenue',
                'entry_type' => 'Credit',
                'debit_amount' => 0,
                'credit_amount' => $revenue->total_amount,
                'line_order' => 2,
                'description' => 'Credit entry for revenue ' . $revenue->revenue_number,
            ]);

            return parent::update($id, [
                'status' => 'Posted',
            ]);
        });
    }

    public function completeRevenue(int|string $id): object
    {
        return $this->transition($id, ['Posted'], 'Completed');
    }

    public function closeRevenue(int|string $id): object
    {
        return $this->transition($id, ['Completed'], 'Closed');
    }

    public function lockRevenue(int|string $id): object
    {
        return $this->transition($id, ['Closed'], 'Locked');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $revenue = $this->findById($id);

        if (! $revenue) {
            throw new \InvalidArgumentException('Revenue not found.');
        }

        if (! in_array((string) $revenue->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Revenue status '{$revenue->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, [
            'status' => $nextStatus,
        ]));
    }

    private function ensureEditable(?object $revenue): void
    {
        if (! $revenue) {
            throw new \InvalidArgumentException('Revenue not found.');
        }

        if (in_array((string) $revenue->status, ['Posted', 'Completed', 'Closed', 'Locked'], true)) {
            throw new \InvalidArgumentException('Posted revenue cannot be changed.');
        }
    }

    private function validateRevenue(array $data): void
    {
        $date = $data['revenue_date'] ?? null;
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

        $revenueType = $data['revenue_type'] ?? null;
        if ($revenueType) {
            $validTypes = ['Harvest', 'Service', 'Other'];
            if (!in_array($revenueType, $validTypes, true)) {
                throw new \InvalidArgumentException("Invalid revenue type: {$revenueType}");
            }
        }
    }
}