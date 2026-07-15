<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceCostCenter;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FinanceCostCenterFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceCostCenter::class;

    public function definition(): array
    {
        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'pond_id' => $this->pondId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'cost_center_code' => strtoupper(fake()->unique()->bothify('CC-######')),
            'cost_center_name' => fake()->words(3, true),
            'cost_center_type' => fake()->randomElement(['Farm', 'Pond', 'Culture Cycle']),
            'effective_from' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'effective_to' => null,
            'status' => fake()->randomElement(['Active', 'Inactive']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
