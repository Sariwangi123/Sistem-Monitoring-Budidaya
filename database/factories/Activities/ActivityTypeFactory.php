<?php

namespace Database\Factories\Activities;

use Activities\Models\ActivityType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityTypeFactory extends Factory
{
    protected $model = ActivityType::class;

    public function definition(): array
    {
        return [
            'activity_category_id' => \Activities\Models\ActivityCategory::inRandomOrder()->first()?->id ?? 1,
            'event_code' => 'EVT-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'activity_name' => $this->faker->unique()->word . ' Activity',
            'icon' => $this->faker->optional()->word,
            'color' => $this->faker->optional()->safeHexColor,
            'is_manual' => $this->faker->boolean(80),
            'is_system' => $this->faker->boolean(10),
            'status' => 'Active',
            'description' => $this->faker->optional()->sentence,
        ];
    }
}