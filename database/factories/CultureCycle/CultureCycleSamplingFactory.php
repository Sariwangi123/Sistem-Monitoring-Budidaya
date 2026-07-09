<?php

namespace Database\Factories\CultureCycle;

use CultureCycle\Models\CultureCycleSampling;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultureCycleSamplingFactory extends Factory
{
    protected $model = CultureCycleSampling::class;

    public function definition(): array
    {
        return [
            'culture_cycle_id' => \CultureCycle\Models\CultureCycle::inRandomOrder()->first()?->id ?? 1,
            'sampling_date' => $this->faker->dateTimeBetween('-2 months', '-1 week'),
            'sample_count' => $this->faker->numberBetween(10, 100),
            'average_weight' => $this->faker->randomFloat(4, 100, 500),
            'average_length' => $this->faker->randomFloat(4, 15, 40),
            'biomass' => $this->faker->randomFloat(4, 500, 5000),
            'adg' => $this->faker->randomFloat(4, 1, 5),
            'survival_rate' => $this->faker->randomFloat(4, 80, 99),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}