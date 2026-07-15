<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceProfitCalculation;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FinanceProfitCalculationFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceProfitCalculation::class;

    public function definition(): array
    {
        $feedCost = fake()->randomFloat(2, 1000000, 5000000);
        $medicineCost = fake()->randomFloat(2, 250000, 1500000);
        $laborCost = fake()->randomFloat(2, 500000, 2500000);
        $operationalCost = fake()->randomFloat(2, 500000, 3000000);
        $costOfProduction = $feedCost + $medicineCost + $laborCost + $operationalCost;
        $revenue = fake()->randomFloat(2, 15000000, 40000000);
        $grossProfit = $revenue - $costOfProduction;

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'harvest_id' => $this->harvestId(),
            'cost_center_id' => $this->costCenterId(),
            'calculation_number' => strtoupper(fake()->unique()->bothify('PROFIT-######')),
            'calculation_date' => now()->toDateString(),
            'period_start' => now()->startOfMonth()->toDateString(),
            'period_end' => now()->endOfMonth()->toDateString(),
            'feed_cost' => $feedCost,
            'medicine_cost' => $medicineCost,
            'labor_cost' => $laborCost,
            'utility_cost' => fake()->randomFloat(2, 100000, 1000000),
            'maintenance_cost' => fake()->randomFloat(2, 100000, 1000000),
            'operational_cost' => $operationalCost,
            'cost_of_production' => $costOfProduction,
            'total_revenue' => $revenue,
            'gross_profit' => $grossProfit,
            'net_profit' => $grossProfit - $operationalCost,
            'harvest_weight' => fake()->randomFloat(2, 100, 1000),
            'cost_per_kg' => fake()->randomFloat(4, 10000, 35000),
            'status' => fake()->randomElement(['Draft', 'Validated', 'Completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
