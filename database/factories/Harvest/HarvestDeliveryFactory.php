<?php

namespace Database\Factories\Harvest;

use Database\Factories\Harvest\Concerns\ResolvesHarvestDependencies;
use Harvest\Models\HarvestDelivery;
use Harvest\Models\HarvestPacking;
use Illuminate\Database\Eloquent\Factories\Factory;

final class HarvestDeliveryFactory extends Factory
{
    use ResolvesHarvestDependencies;

    protected $model = HarvestDelivery::class;

    public function definition(): array
    {
        $packing = HarvestPacking::query()->find($this->harvestPackingId());

        return [
            'harvest_id' => $packing?->harvest_id ?? $this->harvestId(),
            'harvest_packing_id' => $packing?->id ?? $this->harvestPackingId(),
            'customer_id' => $this->customerId(),
            'driver_user_id' => $this->userId(),
            'delivery_code' => strtoupper(fake()->unique()->bothify('HD-######')),
            'document_number' => strtoupper(fake()->unique()->bothify('SJ-HRV-######')),
            'delivery_date' => fake()->dateTimeBetween('-1 week', 'now')->format('Y-m-d'),
            'vehicle_number' => strtoupper(fake()->bothify('B #### ??')),
            'driver_name' => fake()->name(),
            'package_quantity' => fake()->numberBetween(5, 80),
            'delivered_weight' => fake()->randomFloat(2, 50, 500),
            'delivery_status' => fake()->randomElement(['Scheduled', 'In Transit', 'Delivered']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
