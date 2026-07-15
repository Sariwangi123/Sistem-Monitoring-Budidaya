<?php

namespace Finance\Services;

use Finance\Models\FinanceLedger;
use Finance\Repositories\Contracts\FinanceFinancialSummaryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceFinancialSummaryService extends BaseService
{
    public function __construct(FinanceFinancialSummaryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        $calculatedData = $this->calculateSummary(
            $data['cost_center_id'] ?? null,
            $data['period_start'] ?? null,
            $data['period_end'] ?? null
        );

        $mergedData = array_merge($calculatedData, $data);

        if (empty($mergedData['summary_number'])) {
            $mergedData['summary_number'] = 'SUM-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($mergedData));
    }

    public function update(int|string $id, array $data): object
    {
        $summary = $this->findById($id);
        if (!$summary) {
            throw new \InvalidArgumentException('Financial summary not found.');
        }

        $costCenterId = $data['cost_center_id'] ?? $summary->cost_center_id;
        $periodStart = $data['period_start'] ?? $summary->period_start;
        $periodEnd = $data['period_end'] ?? $summary->period_end;

        $calculatedData = $this->calculateSummary($costCenterId, $periodStart, $periodEnd);

        $mergedData = array_merge($calculatedData, $data);

        return DB::transaction(fn (): object => parent::update($id, $mergedData));
    }

    public function completeSummary(int|string $id): object
    {
        return $this->transition($id, ['Draft'], 'Completed');
    }

    public function closeSummary(int|string $id): object
    {
        return $this->transition($id, ['Completed'], 'Closed');
    }

    public function lockSummary(int|string $id): object
    {
        return $this->transition($id, ['Closed'], 'Locked');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $summary = $this->findById($id);

        if (! $summary) {
            throw new \InvalidArgumentException('Financial summary not found.');
        }

        if (! in_array((string) $summary->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Financial summary status '{$summary->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, [
            'status' => $nextStatus,
        ]));
    }

    private function calculateSummary($costCenterId, $periodStart, $periodEnd): array
    {
        if (!$periodStart || !$periodEnd) {
            throw new \InvalidArgumentException('Period start and period end are required for financial summary calculation.');
        }

        $startDateStr = $periodStart instanceof \DateTimeInterface ? $periodStart->format('Y-m-d') : (string) $periodStart;
        $endDateStr = $periodEnd instanceof \DateTimeInterface ? $periodEnd->format('Y-m-d') : (string) $periodEnd;

        $ledgerQuery = FinanceLedger::query()
            ->where('status', 'Posted')
            ->whereBetween('ledger_date', [$startDateStr, $endDateStr]);

        if ($costCenterId) {
            $ledgerQuery->where('cost_center_id', $costCenterId);
        }

        $ledgers = $ledgerQuery->with('expense')->get();

        $totalExpense = 0;
        $totalRevenue = 0;
        $feedCost = 0;
        $medicineCost = 0;
        $laborCost = 0;
        $utilityCost = 0;
        $maintenanceCost = 0;
        $operationalCost = 0;

        foreach ($ledgers as $ledger) {
            if ($ledger->ledger_type === 'Expense') {
                $totalExpense += $ledger->debit_amount;
                $type = $ledger->expense?->expense_type ?? 'Other';
                $amount = $ledger->debit_amount;

                switch ($type) {
                    case 'Feed':
                        $feedCost += $amount;
                        break;
                    case 'Medicine':
                    case 'Vitamin':
                    case 'Chemical':
                        $medicineCost += $amount;
                        break;
                    case 'Labor':
                        $laborCost += $amount;
                        break;
                    case 'Electricity':
                    case 'Utility':
                        $utilityCost += $amount;
                        break;
                    case 'Maintenance':
                        $maintenanceCost += $amount;
                        break;
                    default:
                        $operationalCost += $amount;
                        break;
                }
            } elseif ($ledger->ledger_type === 'Revenue') {
                $totalRevenue += $ledger->credit_amount;
            }
        }

        $costOfProduction = $feedCost + $medicineCost + $laborCost + $utilityCost + $maintenanceCost + $operationalCost;
        $grossProfit = $totalRevenue - $costOfProduction;
        $netProfit = $totalRevenue - $totalExpense;
        $profitMargin = $totalRevenue > 0 ? $netProfit / $totalRevenue : 0;

        return [
            'total_expense' => $totalExpense,
            'total_revenue' => $totalRevenue,
            'cost_of_production' => $costOfProduction,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'profit_margin' => $profitMargin,
        ];
    }
}