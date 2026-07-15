<?php

namespace Tests\Unit\Finance;

use CultureCycle\Models\CultureCycle;
use Finance\Exceptions\LedgerAlreadyPostedException;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceJournal;
use Finance\Models\FinanceJournalEntry;
use Finance\Models\FinanceLedger;
use Finance\Services\FinanceExpenseService;
use Finance\Services\FinanceFinancialSummaryService;
use Finance\Services\FinanceJournalService;
use Finance\Services\FinanceLedgerService;
use Finance\Services\FinanceProfitCalculationService;
use Finance\Services\FinanceRevenueService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\Employee;
use MasterData\Models\Farm;
use MasterData\Models\FishSpecies;
use MasterData\Models\FishStrain;
use MasterData\Models\GeneralReference;
use MasterData\Models\Pond;
use MasterData\Models\PondArea;
use MasterData\Models\Supplier;
use Modules\Users\Models\User;
use Tests\TestCase;

final class FinanceServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_expense_and_revenue_posting_generate_financial_documents(): void
    {
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);

        $expenseService = $this->app->make(FinanceExpenseService::class);
        $revenueService = $this->app->make(FinanceRevenueService::class);

        $expense = $expenseService->create($this->expenseData($context, $costCenter, [
            'expense_number' => 'EXP-SVC-001',
            'document_number' => 'DOC-EXP-SVC-001',
            'status' => 'Draft',
        ]));

        $expenseService->postExpense($expense->id);

        $this->assertDatabaseHas('finance_expenses', ['id' => $expense->id, 'status' => 'Posted']);
        $this->assertDatabaseHas('finance_journals', [
            'source_type' => 'FinanceExpense',
            'source_uuid' => $expense->uuid,
            'status' => 'Posted',
        ]);
        $this->assertDatabaseHas('finance_ledgers', [
            'expense_id' => $expense->id,
            'ledger_type' => 'Expense',
            'status' => 'Posted',
        ]);
        $this->assertDatabaseCount('finance_journal_entries', 2);

        $expenseService->completeExpense($expense->id);
        $expenseService->closeExpense($expense->id);
        $expenseService->lockExpense($expense->id);
        $this->assertDatabaseHas('finance_expenses', ['id' => $expense->id, 'status' => 'Locked']);

        $revenue = $revenueService->create($this->revenueData($context, $costCenter, [
            'revenue_number' => 'REV-SVC-001',
            'document_number' => 'DOC-REV-SVC-001',
            'status' => 'Validated',
        ]));

        $revenueService->postRevenue($revenue->id);

        $this->assertDatabaseHas('finance_revenues', ['id' => $revenue->id, 'status' => 'Posted']);
        $this->assertDatabaseHas('finance_ledgers', [
            'revenue_id' => $revenue->id,
            'ledger_type' => 'Revenue',
            'status' => 'Posted',
        ]);
        $this->assertDatabaseCount('finance_journal_entries', 4);
    }

    public function test_journal_service_rejects_unbalanced_journal_and_posts_balanced_entries(): void
    {
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);
        $journalService = $this->app->make(FinanceJournalService::class);

        $unbalancedJournal = FinanceJournal::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'user_id' => $context['user']->id,
            'journal_number' => 'JRN-UNBALANCED',
            'document_number' => 'DOC-JRN-UNBALANCED',
            'journal_date' => '2026-07-10',
            'journal_type' => 'General',
            'total_debit' => 1000000,
            'total_credit' => 0,
            'status' => 'Draft',
        ]);

        FinanceJournalEntry::query()->create([
            'journal_id' => $unbalancedJournal->id,
            'cost_center_id' => $costCenter->id,
            'account_code' => '5100',
            'account_name' => 'Feed Cost',
            'entry_type' => 'Debit',
            'debit_amount' => 1000000,
            'credit_amount' => 0,
            'line_order' => 1,
        ]);

        $this->expectException(\InvalidArgumentException::class);
        $journalService->postJournal($unbalancedJournal->id);
    }

    public function test_journal_service_posts_balanced_journal_to_ledger(): void
    {
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);
        $journalService = $this->app->make(FinanceJournalService::class);

        $journal = FinanceJournal::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'user_id' => $context['user']->id,
            'journal_number' => 'JRN-BALANCED',
            'document_number' => 'DOC-JRN-BALANCED',
            'journal_date' => '2026-07-10',
            'journal_type' => 'Adjustment',
            'total_debit' => 0,
            'total_credit' => 0,
            'status' => 'Draft',
        ]);

        FinanceJournalEntry::query()->create([
            'journal_id' => $journal->id,
            'cost_center_id' => $costCenter->id,
            'account_code' => '5100',
            'account_name' => 'Feed Cost',
            'entry_type' => 'Debit',
            'debit_amount' => 1000000,
            'credit_amount' => 0,
            'line_order' => 1,
        ]);
        FinanceJournalEntry::query()->create([
            'journal_id' => $journal->id,
            'cost_center_id' => $costCenter->id,
            'account_code' => '1100',
            'account_name' => 'Cash / Bank',
            'entry_type' => 'Credit',
            'debit_amount' => 0,
            'credit_amount' => 1000000,
            'line_order' => 2,
        ]);

        $journalService->postJournal($journal->id);

        $this->assertDatabaseHas('finance_journals', [
            'id' => $journal->id,
            'status' => 'Posted',
            'total_debit' => 1000000,
            'total_credit' => 1000000,
        ]);
        $this->assertSame(2, FinanceLedger::query()->where('journal_id', $journal->id)->count());
    }

    public function test_posted_ledger_cannot_be_updated_or_deleted(): void
    {
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);
        $ledger = FinanceLedger::query()->create($this->ledgerData($context, $costCenter, [
            'ledger_number' => 'LDG-IMMUTABLE',
            'status' => 'Posted',
            'posted_at' => now(),
        ]));

        $ledgerService = $this->app->make(FinanceLedgerService::class);

        try {
            $ledgerService->update($ledger->id, ['description' => 'Should fail']);
            $this->fail('Expected posted ledger update to be rejected.');
        } catch (LedgerAlreadyPostedException $exception) {
            $this->assertSame('Posted ledger cannot be changed.', $exception->getMessage());
        }

        $this->expectException(LedgerAlreadyPostedException::class);
        $ledgerService->delete($ledger->id);
    }

    public function test_profit_calculation_and_financial_summary_use_posted_ledgers(): void
    {
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);
        $expenseService = $this->app->make(FinanceExpenseService::class);
        $revenueService = $this->app->make(FinanceRevenueService::class);

        $expense = $expenseService->create($this->expenseData($context, $costCenter, [
            'expense_number' => 'EXP-CALC-001',
            'document_number' => 'DOC-EXP-CALC-001',
            'amount' => 1200000,
            'total_amount' => 1200000,
            'expense_type' => 'Feed',
            'status' => 'Draft',
        ]));
        $expenseService->postExpense($expense->id);

        $revenue = $revenueService->create($this->revenueData($context, $costCenter, [
            'revenue_number' => 'REV-CALC-001',
            'document_number' => 'DOC-REV-CALC-001',
            'quantity' => 100,
            'unit_price' => 30000,
            'amount' => 3000000,
            'total_amount' => 3000000,
            'status' => 'Draft',
        ]));
        $revenueService->postRevenue($revenue->id);

        $profitService = $this->app->make(FinanceProfitCalculationService::class);
        $profit = $profitService->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'calculation_number' => 'PROFIT-CALC-001',
            'calculation_date' => '2026-07-15',
            'period_start' => '2026-07-01',
            'period_end' => '2026-07-31',
            'status' => 'Draft',
        ]);

        $this->assertSame('1200000.00', $profit->cost_of_production);
        $this->assertSame('3000000.00', $profit->total_revenue);
        $this->assertSame('1800000.00', $profit->gross_profit);
        $this->assertSame('12000.0000', $profit->cost_per_kg);

        $summaryService = $this->app->make(FinanceFinancialSummaryService::class);
        $summary = $summaryService->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'summary_number' => 'SUM-CALC-001',
            'summary_type' => 'Monthly',
            'period_start' => '2026-07-01',
            'period_end' => '2026-07-31',
            'status' => 'Draft',
        ]);

        $this->assertSame('1200000.00', $summary->total_expense);
        $this->assertSame('3000000.00', $summary->total_revenue);
        $this->assertSame('1800000.00', $summary->net_profit);

        $summaryService->completeSummary($summary->id);
        $summaryService->closeSummary($summary->id);
        $summaryService->lockSummary($summary->id);
        $this->assertDatabaseHas('finance_financial_summaries', ['id' => $summary->id, 'status' => 'Locked']);
    }

    private function expenseData(array $context, FinanceCostCenter $costCenter, array $overrides = []): array
    {
        return [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'expense_category_id' => $context['expense_category']->id,
            'supplier_id' => $context['supplier']->id,
            'user_id' => $context['user']->id,
            'expense_number' => 'EXP-SVC-DEFAULT',
            'document_number' => 'DOC-EXP-SVC-DEFAULT',
            'expense_date' => '2026-07-10',
            'expense_type' => 'Feed',
            'payment_method' => 'Cash',
            'amount' => 1000000,
            'tax_amount' => 0,
            'total_amount' => 1000000,
            'currency' => 'IDR',
            'status' => 'Draft',
            ...$overrides,
        ];
    }

    private function revenueData(array $context, FinanceCostCenter $costCenter, array $overrides = []): array
    {
        return [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'revenue_category_id' => $context['revenue_category']->id,
            'customer_id' => $context['customer']->id,
            'user_id' => $context['user']->id,
            'revenue_number' => 'REV-SVC-DEFAULT',
            'document_number' => 'DOC-REV-SVC-DEFAULT',
            'revenue_date' => '2026-07-11',
            'revenue_type' => 'Harvest',
            'quantity' => 100,
            'unit_price' => 25000,
            'amount' => 2500000,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'total_amount' => 2500000,
            'currency' => 'IDR',
            'status' => 'Draft',
            ...$overrides,
        ];
    }

    private function ledgerData(array $context, FinanceCostCenter $costCenter, array $overrides = []): array
    {
        return [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'ledger_number' => 'LDG-SVC-DEFAULT',
            'document_number' => 'DOC-LDG-SVC-DEFAULT',
            'ledger_date' => '2026-07-12',
            'ledger_type' => 'Expense',
            'account_code' => '5100',
            'account_name' => 'Feed Cost',
            'debit_amount' => 1000000,
            'credit_amount' => 0,
            'balance_amount' => 1000000,
            'currency' => 'IDR',
            'status' => 'Draft',
            ...$overrides,
        ];
    }

    private function createCostCenter(array $context): FinanceCostCenter
    {
        return FinanceCostCenter::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_code' => 'CC-SVC-001',
            'cost_center_name' => 'Service Cost Center',
            'cost_center_type' => 'Culture Cycle',
            'effective_from' => '2026-07-01',
            'status' => 'Active',
        ]);
    }

    private function createFinanceContext(): array
    {
        $user = User::query()->create([
            'name' => 'Finance Service Tester',
            'email' => 'finance.service.tester@example.com',
            'password' => 'password',
            'is_active' => true,
        ]);

        $company = Company::query()->create([
            'company_code' => 'CMP-FSVC',
            'company_name' => 'Finance Service Company',
        ]);

        $farm = Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-FSVC',
            'farm_name' => 'Finance Service Farm',
        ]);

        $pondArea = PondArea::query()->create([
            'farm_id' => $farm->id,
            'pond_area_code' => 'PA-FSVC',
            'pond_area_name' => 'Finance Service Pond Area',
        ]);

        $pond = Pond::query()->create([
            'pond_area_id' => $pondArea->id,
            'pond_code' => 'PND-FSVC',
            'pond_name' => 'Finance Service Pond',
        ]);

        $fishSpecies = FishSpecies::query()->create([
            'fish_species_code' => 'FSP-FSVC',
            'fish_species_name' => 'Finance Service Species',
        ]);

        $fishStrain = FishStrain::query()->create([
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_code' => 'FST-FSVC',
            'fish_strain_name' => 'Finance Service Strain',
        ]);

        $supplier = Supplier::query()->create([
            'supplier_code' => 'SUP-FSVC',
            'supplier_name' => 'Finance Service Supplier',
            'supplier_type' => 'operational',
        ]);

        $employee = Employee::query()->create([
            'employee_code' => 'EMP-FSVC',
            'employee_name' => 'Finance Service Employee',
            'is_active' => true,
        ]);

        $customer = Customer::query()->create([
            'customer_code' => 'CUS-FSVC',
            'customer_name' => 'Finance Service Customer',
            'customer_type' => 'corporate',
        ]);

        $cultureCycle = CultureCycle::query()->create([
            'uuid' => Str::uuid()->toString(),
            'company_id' => $company->id,
            'farm_id' => $farm->id,
            'pond_area_id' => $pondArea->id,
            'pond_id' => $pond->id,
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_id' => $fishStrain->id,
            'supplier_id' => $supplier->id,
            'employee_id' => $employee->id,
            'cycle_code' => 'CYC-FSVC',
            'cycle_name' => 'Finance Service Cycle',
            'status' => 'Active',
        ]);

        $expenseCategory = GeneralReference::query()->create([
            'reference_code' => 'FIN-EXP-SVC',
            'reference_name' => 'Finance Expense Service',
            'reference_group' => 'finance_expense_category',
            'reference_value' => 'Feed',
            'is_active' => true,
        ]);

        $revenueCategory = GeneralReference::query()->create([
            'reference_code' => 'FIN-REV-SVC',
            'reference_name' => 'Finance Revenue Service',
            'reference_group' => 'finance_revenue_category',
            'reference_value' => 'Harvest',
            'is_active' => true,
        ]);

        return [
            'user' => $user,
            'company' => $company,
            'farm' => $farm,
            'pond_area' => $pondArea,
            'pond' => $pond,
            'fish_species' => $fishSpecies,
            'fish_strain' => $fishStrain,
            'supplier' => $supplier,
            'employee' => $employee,
            'customer' => $customer,
            'culture_cycle' => $cultureCycle,
            'expense_category' => $expenseCategory,
            'revenue_category' => $revenueCategory,
        ];
    }
}
