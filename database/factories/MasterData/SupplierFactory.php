<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Supplier;

final class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'supplier_code' => strtoupper(fake()->unique()->lexify('SUP???')),
            'supplier_name' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'address' => fake()->address(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}