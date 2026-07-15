<?php

namespace Database\Factories\Finance;

use Database\Factories\Finance\Concerns\ResolvesFinanceDependencies;
use Finance\Models\FinanceLedger;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class FinanceLedgerFactory extends Factory
{
    use ResolvesFinanceDependencies;

    protected $model = FinanceLedger::class;

    public function definition(): array
    {
        $debit = fake()->randomFloat(2, 100000, 5000000);

        return [
            'company_id' => $this->companyId(),
            'farm_id' => $this->farmId(),
            'culture_cycle_id' => $this->cultureCycleId(),
            'cost_center_id' => $this->costCenterId(),
            'expense_id' => $this->expenseId(),
            'revenue_id' => null,
            'journal_id' => $this->journalId(),
            'ledger_number' => strtoupper(fake()->unique()->bothify('LDG-######')),
            'document_number' => strtoupper(fake()->unique()->bothify('DOC-LDG-######')),
            'ledger_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'ledger_type' => 'Expense',
            'account_code' => '5100',
            'account_name' => 'Operational Expense',
            'debit_amount' => $debit,
            'credit_amount' => 0,
            'balance_amount' => $debit,
            'currency' => 'IDR',
            'source_type' => 'FinanceExpense',
            'source_uuid' => (string) Str::uuid(),
            'posted_at' => now(),
            'status' => 'Posted',
            'description' => fake()->optional()->sentence(),
        ];
    }
}
