<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FeedType;

final class FeedTypeFactory extends Factory
{
    protected $model = FeedType::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'feed_brand_id' => \MasterData\Models\FeedBrand::factory(),
            'feed_category_id' => \MasterData\Models\FeedCategory::factory(),
            'feed_type_code' => strtoupper(fake()->unique()->lexify('FEED???')),
            'feed_type_name' => fake()->word(),
            'protein_content' => fake()->randomFloat(2, 20, 40),
            'fat_content' => fake()->randomFloat(2, 2, 10),
            'fiber_content' => fake()->randomFloat(2, 2, 8),
            'moisture' => fake()->randomFloat(2, 8, 14),
            'pellet_size' => fake()->randomFloat(2, 1, 5),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
