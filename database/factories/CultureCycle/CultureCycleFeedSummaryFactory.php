<?php

namespace Database\Factories\CultureCycle;

use CultureCycle\Models\CultureCycleFeedSummary;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultureCycleFeedSummaryFactory extends Factory
{
    protected $model = CultureCycleFeedSummary::class;

    public function definition(): array
    {
        return [
            'culture_cycle_id' => \CultureCycle\Models\CultureCycle::inRandomOrder()->first()?->id ?? 1,
            'feed_brand_id' => \MasterData\Models\FeedBrand::inRandomOrder()->first()?->id ?? 1,
            'feed_type_id' => \MasterData\Models\FeedType::inRandomOrder()->first()?->id ?? 1,
            'feed_date' => $this->faker->dateTimeBetween('-2 months', '-1 week'),
            'feed_quantity' => $this->faker->randomFloat(4, 10, 500),
            'feeding_frequency' => $this->faker->numberBetween(1, 5),
            'feeding_duration' => $this->faker->numberBetween(15, 120),
            'fcr' => $this->faker->randomFloat(4, 1.0, 2.5),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}