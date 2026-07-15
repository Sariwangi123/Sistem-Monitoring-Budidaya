<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FishStrain;

final class FishStrainFactory extends Factory
{
    protected $model = FishStrain::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'fish_species_id' => \MasterData\Models\FishSpecies::factory(),
            'fish_strain_code' => strtoupper(fake()->unique()->lexify('STR???')),
            'fish_strain_name' => fake()->unique()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
