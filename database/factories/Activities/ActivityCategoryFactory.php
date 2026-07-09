<?php

namespace Database\Factories\Activities;

use Activities\Models\ActivityCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityCategoryFactory extends Factory
{
    protected $model = ActivityCategory::class;

    public function definition(): array
    {
        return [
            'category_code' => 'CAT-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'category_name' => $this->faker->unique()->word . ' Category',
            'description' => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }
}