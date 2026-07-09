<?php

namespace Database\Factories\CultureCycle;

use CultureCycle\Models\CultureCycleWaterQuality;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultureCycleWaterQualityFactory extends Factory
{
    protected $model = CultureCycleWaterQuality::class;

    public function definition(): array
    {
        return [
            'culture_cycle_id' => \CultureCycle\Models\CultureCycle::inRandomOrder()->first()?->id ?? 1,
            'measurement_date' => $this->faker->dateTimeBetween('-2 months', '-1 week'),
            'temperature' => $this->faker->randomFloat(2, 25, 32),
            'ph' => $this->faker->randomFloat(2, 6.5, 8.5),
            'do' => $this->faker->randomFloat(2, 3, 8),
            'ammonia' => $this->faker->randomFloat(4, 0, 2),
            'nitrite' => $this->faker->randomFloat(4, 0, 1),
            'salinity' => $this->faker->randomFloat(2, 0, 35),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}