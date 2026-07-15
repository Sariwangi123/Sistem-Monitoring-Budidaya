<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FishSpecies;

final class FishSpeciesFactory extends Factory
{
    protected $model = FishSpecies::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'fish_species_code' => strtoupper(fake()->unique()->lexify('SP???')),
            'fish_species_name' => fake()->word(),
            'scientific_name' => fake()->unique()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
