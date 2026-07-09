<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Settings\Models\GlobalSetting;

final class GlobalSettingFactory extends Factory
{
    protected $model = GlobalSetting::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'key' => fake()->unique()->slug(),
            'value' => ['value' => fake()->word()],
            'type' => 'string',
        ];
    }
}
