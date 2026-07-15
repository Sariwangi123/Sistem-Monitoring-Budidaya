<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestBatch;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestBatchFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = HarvestBatch::class;

    public function definition(): array
    {
        $harvest = Harvest::query()->find($this->harvestId());
        $population = fake()->numberBetween(500, 2500);
        $averageWeight = fake()->randomFloat(4, 0.15, 0.8);
        $netWeight = $population * $averageWeight;

        return [
            'harvest_id' => $harvest?->id ?? $this->harvestId(),
            'culture_cycle_id' => $harvest?->culture_cycle_id ?? $this->cultureCycleId(),
            'batch_code' => strtoupper(fake()->unique()->bothify('HB-######')),
            'batch_name' => fake()->words(3, true),
            'harvest_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'harvest_population' => $population,
            'gross_weight' => $netWeight + fake()->randomFloat(2, 5, 50),
            'net_weight' => $netWeight,
            'average_weight' => $averageWeight,
            'status' => fake()->randomElement(['Harvesting', 'QC', 'Packing', 'Delivered', 'Completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
