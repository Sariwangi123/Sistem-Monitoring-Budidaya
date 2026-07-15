<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestQualityControl;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestQualityControlFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = HarvestQualityControl::class;

    public function definition(): array
    {
        $batch = HarvestBatch::query()->find($this->harvestBatchId());

        return [
            'harvest_id' => $batch?->harvest_id ?? $this->harvestId(),
            'harvest_batch_id' => $batch?->id ?? $this->harvestBatchId(),
            'qc_user_id' => $this->userId(),
            'qc_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'average_weight' => fake()->randomFloat(4, 0.15, 0.8),
            'fish_size' => fake()->randomElement(['Small', 'Medium', 'Large']),
            'fish_condition' => fake()->randomElement(['Fresh', 'Good', 'Bruised']),
            'damage_rate' => fake()->randomFloat(4, 0, 5),
            'qc_status' => fake()->randomElement(['Passed', 'Conditional', 'Rejected']),
            'qc_notes' => fake()->optional()->sentence(),
        ];
    }
}
