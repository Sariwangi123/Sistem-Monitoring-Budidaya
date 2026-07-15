<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestGrade;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestGradeFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = HarvestGrade::class;

    public function definition(): array
    {
        $batch = HarvestBatch::query()->find($this->harvestBatchId());
        $fishCount = fake()->numberBetween(100, 1000);
        $averageWeight = fake()->randomFloat(4, 0.15, 0.8);

        return [
            'harvest_id' => $batch?->harvest_id ?? $this->harvestId(),
            'harvest_batch_id' => $batch?->id ?? $this->harvestBatchId(),
            'grade_code' => strtoupper(fake()->unique()->bothify('G-###')),
            'grade_name' => fake()->randomElement(['Grade A', 'Grade B', 'Grade C', 'Grade BS']),
            'fish_count' => $fishCount,
            'total_weight' => $fishCount * $averageWeight,
            'average_weight' => $averageWeight,
            'quality_status' => fake()->randomElement(['Accepted', 'Hold', 'Rejected']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
