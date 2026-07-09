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
            'brand_name' => fake()->unique()->company(),
            'manufacturer' => fake()->company(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}