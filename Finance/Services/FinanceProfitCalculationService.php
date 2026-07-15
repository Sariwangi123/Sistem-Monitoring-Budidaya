<?php

namespace Finance\Services;

use Finance\Exceptions\ProfitCalculationException;
use Finance\Models\FinanceLedger;
use Finance\Models\FinanceRevenue;
use Finance\Repositories\Contracts\FinanceProfitCalculationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceProfitCalculationService extends BaseService
{
    public function __construct(FinanceProfitCalculationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        $calculatedData = $this->calculateProfit(
            $data['cost_center_id'] ?? null,
            $data['period_start'] ?? null,
            $data['period_end'] ?? null
        );

        $mergedData = array_merge($calculatedData, $data);

        if (empty($mergedData['calculation_number'])) {
            $mergedData['calculation_number'] = 'PROFIT-' . strtoupper(uniqid());
        }
        if (empty($mergedData['calculation_date'])) {
            $mergedData['calculation_date'] = now()->format('Y-m-d');
        }

        return DB::transaction(fn (): object => parent::create($mergedData));
    }

    public function update(int|string $id, array $data): object
    {
        $calculation = $this->findById($id);
        if (!$calculation) {
            throw new \InvalidArgumentException('Profit calculation not found.');
        }

        $costCenterId = $data['cost_center_id'] ?? $calculation->cost_center_id;
        $periodStart = $data['period_start'] ?? $calculation->period_start;
        $periodEnd = $data['period_end'] ?? $calculation->period_end;

        $calculatedData = $this->calculateProfit($costCenterId, $periodStart, $periodEnd);

        $mergedData = array_merge($calculatedData, $data);

        return DB::transaction(fn (): object => parent::update($id, $mergedData));
    }

    public function completeProfitCalculation(int|string $id): object
    {
        $calculation = $this->findById($id);
        if (!$calculation) {
            throw new \InvalidArgumentException('Profit calculation not found.');
        }

        if ((string) $calculation->status !== 'Draft') {
            throw new \InvalidArgumentException("Status '{$calculation->status}' cannot transition to 'Completed'.");
        }

        return DB::transaction(fn (): object => parent::update($id, [
            'status' => 'Completed',
        ]));
    }

    private function calculateProfit($costCenterId, $periodStart, $periodEnd): array
    {
        if (!$costCenterId || !$periodStart || !$periodEnd) {
            throw new ProfitCalculationException('Cost center ID, period start, and period end are required for profit calculation.');
        }

        try {
            $startDateStr = $periodStart instanceof \DateTimeInterface ? $periodStart->format('Y-m-d') : (string) $periodStart;
            $endDateStr = $periodEnd instanceof \DateTimeInterface ? $periodEnd->format('Y-m-d') : (string) $periodEnd;

            $ledgers = FinanceLedger::query()
                ->where('cost_center_id', $costCenterId)
                ->where('status', 'Posted')
                ->whereBetween('ledger_date', [$startDateStr, $endDateStr])
                ->with('expense')
                ->get();

            $feedCost = 0;
            $medicineCost = 0;
            $laborCost = 0;
            $utilityCost = 0;
            $maintenanceCost = 0;
            $operationalCost = 0;

            foreach ($ledgers as $ledger) {
                if ($ledger->ledger_type === 'Expense') {
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
                }
            }

            $totalRevenue = FinanceLedger::query()
                ->where('cost_center_id', $costCenterId)
                ->where('status', 'Posted')
                ->where('ledger_type', 'Revenue')
                ->whereBetween('ledger_date', [$startDateStr, $endDateStr])
                ->sum('credit_amount');

            $costOfProduction = $feedCost + $medicineCost + $laborCost + $utilityCost + $maintenanceCost + $operationalCost;
            $grossProfit = $totalRevenue - $costOfProduction;
            $netProfit = $grossProfit;

            $harvestWeight = FinanceRevenue::query()
                ->where('cost_center_id', $costCenterId)
                ->where('status', 'Posted')
                ->where('revenue_type', 'Harvest')
                ->whereBetween('revenue_date', [$startDateStr, $endDateStr])
                ->sum('quantity');

            $costPerKg = $harvestWeight > 0 ? $costOfProduction / $harvestWeight : 0;

            return [
                'feed_cost' => $feedCost,
                'medicine_cost' => $medicineCost,
                'labor_cost' => $laborCost,
                'utility_cost' => $utilityCost,
                'maintenance_cost' => $maintenanceCost,
                'operational_cost' => $operationalCost,
                'cost_of_production' => $costOfProduction,
                'total_revenue' => $totalRevenue,
                'gross_profit' => $grossProfit,
                'net_profit' => $netProfit,
                'harvest_weight' => $harvestWeight,
                'cost_per_kg' => $costPerKg,
            ];
        } catch (\Exception $e) {
            throw new ProfitCalculationException('Profit calculation failed: ' . $e->getMessage(), 0, $e);
        }
    }
}