<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\District;

final class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'city_id' => \MasterData\Models\City::factory(),
            'district_code' => strtoupper(fake()->unique()->lexify('DIST???')),
            'district_name' => fake()->streetName(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}