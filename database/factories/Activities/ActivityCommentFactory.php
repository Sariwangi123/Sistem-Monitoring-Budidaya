<?php

namespace Database\Factories\Activities;

use Activities\Models\ActivityComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityCommentFactory extends Factory
{
    protected $model = ActivityComment::class;

    public function definition(): array
    {
        return [
            'activity_id' => \Activities\Models\Activity::inRandomOrder()->first()?->id ?? 1,
            'user_id' => \Modules\Users\Models\User::inRandomOrder()->first()?->id ?? 1,
            'comment' => $this->faker->paragraph,
        ];
    }
}