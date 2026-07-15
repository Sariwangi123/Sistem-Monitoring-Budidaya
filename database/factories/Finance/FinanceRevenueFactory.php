<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceRevenue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class FinanceRevenueFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceRevenue::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 100, 1000);
        $unitPrice = fake()->randomFloat(2, 25000, 45000);
        $amount = $quantity * $unitPrice;

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'cost_center_id' => $this->costCenterId(),
            'revenue_category_id' => $this->revenueCategoryId(),
            'harvest_id' => $this->harvestId(),
            'harvest_delivery_id' => $this->harvestDeliveryId(),
            'customer_id' => $this->customerId(),
            'user_id' => $this->userId(),
            'revenue_number' => strtoupper(fake()->unique()->bothify('REV-######')),
            'document_number' => strtoupper(fake()->unique()->bothify('DOC-REV-######')),
            'revenue_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'revenue_type' => fake()->randomElement(['Harvest', 'Service', 'Other']),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'amount' => $amount,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total_amount' => $amount,
            'currency' => 'IDR',
            'source_type' => 'Harvest',
            'source_uuid' => (string) Str::uuid(),
            'status' => fake()->randomElement(['Draft', 'Validated', 'Posted']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
