<?php

namespace Database\Seeders\Finance;

use Finance\Models\FinanceCostAllocation;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceExpense;
use Finance\Models\FinanceFinancialSummary;
use Finance\Models\FinanceJournal;
use Finance\Models\FinanceJournalEntry;
use Finance\Models\FinanceLedger;
use Finance\Models\FinanceProfitCalculation;
use Finance\Models\FinanceRevenue;
use Illuminate\Database\Seeder;

final class FinanceSeeder extends Seeder
{
    public function run(): void
    {
        $costCenter = FinanceCostCenter::query()->firstOrCreate(
            ['cost_center_code' => 'CC-FIN-SEED'],
            FinanceCostCenter::factory()->make([
                'cost_center_name' => 'Seed Finance Cost Center',
                'cost_center_type' => 'Culture Cycle',
                'status' => 'Active',
            ])->toArray()
        );

        $expense = FinanceExpense::query()->firstOrCreate(
            ['expense_number' => 'EXP-FIN-SEED'],
            FinanceExpense::factory()->make([
                'cost_center_id' => $costCenter->id,
                'document_number' => 'DOC-EXP-FIN-SEED',
                'expense_type' => 'Feed',
                'status' => 'Posted',
            ])->toArray()
        );

        $revenue = FinanceRevenue::query()->firstOrCreate(
            ['revenue_number' => 'REV-FIN-SEED'],
            FinanceRevenue::factory()->make([
                'cost_center_id' => $costCenter->id,
                'document_number' => 'DOC-REV-FIN-SEED',
                'revenue_type' => 'Harvest',
                'status' => 'Posted',
            ])->toArray()
        );

        $journal = FinanceJournal::query()->firstOrCreate(
            ['journal_number' => 'JRN-FIN-SEED'],
            FinanceJournal::factory()->make([
                'document_number' => 'DOC-JRN-FIN-SEED',
                'journal_type' => 'Operational',
                'status' => 'Posted',
            ])->toArray()
        );

        $ledger = FinanceLedger::query()->firstOrCreate(
            ['ledger_number' => 'LDG-FIN-SEED'],
            FinanceLedger::factory()->make([
                'cost_center_id' => $costCenter->id,
                'expense_id' => $expense->id,
                'revenue_id' => null,
                'journal_id' => $journal->id,
                'document_number' => 'DOC-LDG-FIN-SEED',
                'ledger_type' => 'Expense',
                'status' => 'Posted',
            ])->toArray()
        );

        FinanceJournalEntry::query()->firstOrCreate(
            ['journal_id' => $journal->id, 'ledger_id' => $ledger->id, 'line_order' => 1],
            FinanceJournalEntry::factory()->make([
                'cost_center_id' => $costCenter->id,
                'account_code' => '5100',
                'account_name' => 'Feed Cost',
                'entry_type' => 'Debit',
            ])->toArray()
        );

        FinanceCostAllocation::query()->firstOrCreate(
            ['allocation_number' => 'ALLOC-FIN-SEED'],
            FinanceCostAllocation::factory()->make([
                'ledger_id' => $ledger->id,
                'source_cost_center_id' => $costCenter->id,
                'target_cost_center_id' => $costCenter->id,
                'status' => 'Posted',
            ])->toArray()
        );

        FinanceProfitCalculation::query()->firstOrCreate(
            ['calculation_number' => 'PROFIT-FIN-SEED'],
            FinanceProfitCalculation::factory()->make([
                'cost_center_id' => $costCenter->id,
                'status' => 'Completed',
            ])->toArray()
        );

        FinanceFinancialSummary::query()->firstOrCreate(
            ['summary_number' => 'SUM-FIN-SEED'],
            FinanceFinancialSummary::factory()->make([
                'cost_center_id' => $costCenter->id,
                'summary_type' => 'Cycle',
                'status' => 'Completed',
            ])->toArray()
        );

        FinanceExpense::factory()->count(2)->create(['cost_center_id' => $costCenter->id]);
        FinanceRevenue::factory()->count(2)->create(['cost_center_id' => $costCenter->id]);
    }
}
