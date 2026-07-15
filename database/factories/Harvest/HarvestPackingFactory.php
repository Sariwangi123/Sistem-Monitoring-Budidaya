<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\HarvestGrade;
use Harvest\Models\HarvestPacking;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestPackingFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = HarvestPacking::class;

    public function definition(): array
    {
        $grade = HarvestGrade::query()->find($this->harvestGradeId());
        $netWeight = fake()->randomFloat(2, 50, 500);

        return [
            'harvest_id' => $grade?->harvest_id ?? $this->harvestId(),
            'harvest_batch_id' => $grade?->harvest_batch_id ?? $this->harvestBatchId(),
            'harvest_grade_id' => $grade?->id ?? $this->harvestGradeId(),
            'operator_user_id' => $this->userId(),
            'packing_code' => strtoupper(fake()->unique()->bothify('HP-######')),
            'packing_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'package_type' => fake()->randomElement(['Box', 'Crate', 'Styrofoam']),
            'package_quantity' => fake()->numberBetween(5, 80),
            'net_weight' => $netWeight,
            'gross_weight' => $netWeight + fake()->randomFloat(2, 2, 25),
            'status' => fake()->randomElement(['Packed', 'Delivered']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
