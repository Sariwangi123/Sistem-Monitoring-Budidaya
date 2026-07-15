<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Company;

final class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'company_code' => strtoupper(fake()->unique()->lexify('CMP???')),
            'company_name' => fake()->unique()->company(),
            'legal_name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'website' => fake()->url(),
            'tax_number' => fake()->unique()->numerify('##.###.###.#-###.###'),
            'address' => fake()->address(),
            'province_id' => \MasterData\Models\Province::factory(),
            'city_id' => \MasterData\Models\City::factory(),
            'district_id' => \MasterData\Models\District::factory(),
            'village_id' => \MasterData\Models\Village::factory(),
            'postal_code' => fake()->postcode(),
            'logo' => fake()->optional()->imageUrl(),
        ];
    }
}
