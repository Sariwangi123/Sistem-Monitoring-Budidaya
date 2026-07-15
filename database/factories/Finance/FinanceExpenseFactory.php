<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceExpense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class FinanceExpenseFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceExpense::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 100000, 5000000);
        $tax = $amount * 0.11;

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'cost_center_id' => $this->costCenterId(),
            'expense_category_id' => $this->expenseCategoryId(),
            'supplier_id' => $this->supplierId(),
            'activity_id' => $this->activityId(),
            'inventory_movement_id' => null,
            'user_id' => $this->userId(),
            'expense_number' => strtoupper(fake()->unique()->bothify('EXP-######')),
            'document_number' => strtoupper(fake()->unique()->bothify('DOC-EXP-######')),
            'expense_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'expense_type' => fake()->randomElement(['Feed', 'Medicine', 'Labor', 'Electricity', 'Maintenance', 'Operational']),
            'payment_method' => fake()->randomElement(['Cash', 'Bank Transfer']),
            'amount' => $amount,
            'tax_amount' => $tax,
            'total_amount' => $amount + $tax,
            'currency' => 'IDR',
            'source_type' => fake()->randomElement(['Warehouse', 'Activities', 'Manual']),
            'source_uuid' => (string) Str::uuid(),
            'status' => fake()->randomElement(['Draft', 'Validated', 'Posted']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
