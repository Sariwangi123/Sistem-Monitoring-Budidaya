<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceJournalEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

final class FinanceJournalEntryFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceJournalEntry::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(2, 100000, 5000000);

        return [
            'journal_id' => $this->journalId(),
            'ledger_id' => $this->ledgerId(),
            'cost_center_id' => $this->costCenterId(),
            'account_code' => '5100',
            'account_name' => 'Operational Expense',
            'entry_type' => fake()->randomElement(['Debit', 'Credit']),
            'debit_amount' => $amount,
            'credit_amount' => 0,
            'line_order' => fake()->numberBetween(1, 10),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
