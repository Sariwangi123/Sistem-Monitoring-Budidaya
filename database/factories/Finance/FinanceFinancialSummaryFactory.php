<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceFinancialSummary;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FinanceFinancialSummaryFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceFinancialSummary::class;

    public function definition(): array
    {
        $expense = fake()->randomFloat(2, 5000000, 15000000);
        $revenue = fake()->randomFloat(2, 15000000, 40000000);
        $grossProfit = $revenue - $expense;
        $netProfit = $grossProfit - fake()->randomFloat(2, 500000, 3000000);

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'cost_center_id' => $this->costCenterId(),
            'summary_number' => strtoupper(fake()->unique()->bothify('SUM-######')),
            'summary_type' => fake()->randomElement(['Monthly', 'Cycle', 'Harvest']),
            'period_start' => now()->startOfMonth()->toDateString(),
            'period_end' => now()->endOfMonth()->toDateString(),
            'total_expense' => $expense,
            'total_revenue' => $revenue,
            'cost_of_production' => $expense,
            'gross_profit' => $grossProfit,
            'net_profit' => $netProfit,
            'profit_margin' => $revenue > 0 ? ($netProfit / $revenue) * 100 : 0,
            'status' => fake()->randomElement(['Draft', 'Validated', 'Completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
