<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FeedCategory;

final class FeedCategoryFactory extends Factory
{
    protected $model = FeedCategory::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'feed_category_code' => strtoupper(fake()->unique()->lexify('FCAT???')),
            'feed_category_name' => fake()->unique()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
