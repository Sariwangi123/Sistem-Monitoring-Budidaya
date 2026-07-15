<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceJournal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class FinanceJournalFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceJournal::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 500000, 10000000);

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'user_id' => $this->userId(),
            'journal_number' => strtoupper(fake()->unique()->bothify('JRN-######')),
            'document_number' => strtoupper(fake()->unique()->bothify('DOC-JRN-######')),
            'journal_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'journal_type' => fake()->randomElement(['Expense', 'Revenue', 'Adjustment', 'Operational']),
            'total_debit' => $amount,
            'total_credit' => $amount,
            'source_type' => 'Finance',
            'source_uuid' => (string) Str::uuid(),
            'status' => fake()->randomElement(['Draft', 'Validated', 'Posted']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
