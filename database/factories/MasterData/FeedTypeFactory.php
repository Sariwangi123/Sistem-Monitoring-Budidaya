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
            'feed_code' => strtoupper(fake()->unique()->lexify('FEED???')),
            'feed_name' => fake()->word(),
            'protein' => fake()->randomFloat(2, 20, 40),
            'fat' => fake()->randomFloat(2, 2, 10),
            'fiber' => fake()->randomFloat(2, 2, 8),
            'moisture' => fake()->randomFloat(2, 8, 14),
            'pellet_size' => fake()->randomElement(['1mm', '2mm', '3mm', '4mm', '5mm']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}