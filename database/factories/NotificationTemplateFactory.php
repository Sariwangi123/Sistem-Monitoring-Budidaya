<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Notifications\Models\NotificationTemplate;

final class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationTemplate::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'channel' => 'email',
            'name' => fake()->unique()->slug(),
            'subject' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'is_active' => true,
        ];
    }
}
