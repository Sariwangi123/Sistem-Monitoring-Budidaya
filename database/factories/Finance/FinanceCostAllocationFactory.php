<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceCostAllocation;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FinanceCostAllocationFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceCostAllocation::class;

    public function definition(): array
    {
        return [
            'ledger_id' => $this->ledgerId(),
            'source_cost_center_id' => $this->costCenterId(),
            'target_cost_center_id' => $this->costCenterId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'harvest_id' => $this->harvestId(),
            'allocation_number' => strtoupper(fake()->unique()->bothify('ALLOC-######')),
            'allocation_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'allocation_method' => fake()->randomElement(['Direct', 'Weight Based', 'Population Based', 'Manual']),
            'allocation_percentage' => fake()->randomFloat(4, 10, 100),
            'allocated_amount' => fake()->randomFloat(2, 100000, 5000000),
            'status' => fake()->randomElement(['Draft', 'Validated', 'Posted']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
