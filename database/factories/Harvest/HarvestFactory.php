<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\Harvest;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = Harvest::class;

    public function definition(): array
    {
        $estimatedPopulation = fake()->numberBetween(1000, 5000);
        $totalPopulation = fake()->numberBetween(500, $estimatedPopulation);
        $averageWeight = fake()->randomFloat(4, 0.15, 0.8);
        $totalWeight = $totalPopulation * $averageWeight;

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'pond_area_id' => $this->pondAreaId(),
            'pond_id' => $this->pondId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'customer_id' => $this->customerId(),
            'responsible_user_id' => $this->userId(),
            'activity_id' => $this->activityId(),
            'harvest_code' => strtoupper(fake()->unique()->bothify('HRV-######')),
            'harvest_name' => fake()->words(3, true),
            'harvest_type' => fake()->randomElement(['Partial Harvest', 'Final Harvest', 'Emergency Harvest']),
            'planned_harvest_date' => fake()->dateTimeBetween('-1 week', '+1 week')->format('Y-m-d'),
            'harvest_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'started_at' => now()->subHours(4),
            'completed_at' => now(),
            'estimated_population' => $estimatedPopulation,
            'estimated_biomass' => fake()->randomFloat(2, 250, 2500),
            'total_harvest_population' => $totalPopulation,
            'total_harvest_weight' => $totalWeight,
            'average_weight' => $averageWeight,
            'survival_rate' => fake()->randomFloat(4, 80, 98),
            'feed_conversion_ratio' => fake()->randomFloat(4, 1.1, 1.8),
            'average_daily_gain' => fake()->randomFloat(4, 1, 5),
            'status' => fake()->randomElement(['Planning', 'Scheduled', 'Ready', 'Harvesting', 'QC', 'Packing', 'Delivered', 'Completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
