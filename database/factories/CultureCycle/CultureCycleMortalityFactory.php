<?php

namespace Database\Factories\CultureCycle;

use CultureCycle\Models\CultureCycleMortality;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultureCycleMortalityFactory extends Factory
{
    protected $model = CultureCycleMortality::class;

    public function definition(): array
    {
        return [
            'culture_cycle_id' => \CultureCycle\Models\CultureCycle::inRandomOrder()->first()?->id ?? 1,
            'mortality_date' => $this->faker->dateTimeBetween('-2 months', '-1 week'),
            'dead_count' => $this->faker->numberBetween(1, 100),
            'cause_of_death' => $this->faker->optional()->randomElement(['disease', 'stress', 'water_quality', 'cannibalism', 'unknown']),
            'cumulative_mortality' => $this->faker->numberBetween(100, 5000),
            'mortality_rate' => $this->faker->randomFloat(4, 0.1, 10),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}