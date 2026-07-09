<?php

namespace Database\Factories\Activities;

use Activities\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition(): array
    {
        $activityDate = $this->faker->dateTimeBetween('-3 months', 'now');

        return [
            'company_id' => \MasterData\Models\Company::inRandomOrder()->first()?->id ?? 1,
            'farm_id' => \MasterData\Models\Farm::inRandomOrder()->first()?->id ?? 1,
            'pond_area_id' => \MasterData\Models\PondArea::inRandomOrder()->first()?->id ?? 1,
            'pond_id' => \MasterData\Models\Pond::inRandomOrder()->first()?->id ?? 1,
            'culture_cycle_id' => \CultureCycle\Models\CultureCycle::inRandomOrder()->first()?->id ?? null,
            'activity_type_id' => \Activities\Models\ActivityType::inRandomOrder()->first()?->id ?? 1,
            'user_id' => \Modules\Users\Models\User::inRandomOrder()->first()?->id ?? 1,
            'activity_date' => $activityDate,
            'activity_time' => $activityDate,
            'event_code' => 'ACT-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->optional()->paragraph,
            'status' => $this->faker->randomElement(['Completed', 'Pending', 'Cancelled']),
            'reference_type' => $this->faker->optional()->randomElement(['sampling', 'feeding', 'harvest']),
            'reference_uuid' => $this->faker->optional()->uuid,
            'metadata' => $this->faker->optional()->randomElement([
                json_encode(['key1' => 'value1']),
                json_encode(['key2' => 'value2']),
                null,
            ]),
        ];
    }
}