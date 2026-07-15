<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FeedBrand;

final class FeedBrandFactory extends Factory
{
    protected $model = FeedBrand::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'feed_brand_code' => strtoupper(fake()->unique()->lexify('FBR???')),
            'feed_brand_name' => fake()->unique()->company(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
