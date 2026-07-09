<?php

namespace Database\Factories\Activities;

use Activities\Models\ActivityAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityAttachmentFactory extends Factory
{
    protected $model = ActivityAttachment::class;

    public function definition(): array
    {
        return [
            'activity_id' => \Activities\Models\Activity::inRandomOrder()->first()?->id ?? 1,
            'file_name' => $this->faker->word . '.' . $this->faker->fileExtension,
            'file_type' => $this->faker->mimeType,
            'file_size' => $this->faker->numberBetween(1024, 10485760),
            'storage_path' => 'uploads/activities/' . $this->faker->uuid . '/' . $this->faker->word . '.' . $this->faker->fileExtension,
            'description' => $this->faker->optional()->sentence,
        ];
    }
}