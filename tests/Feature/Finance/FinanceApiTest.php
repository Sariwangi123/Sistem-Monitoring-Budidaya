<?php

namespace Tests\Feature\Finance;

use CultureCycle\Models\CultureCycle;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceLedger;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
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

final class FinanceApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1/finance';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'name' => 'Finance Tester',
            'email' => 'finance.tester@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }

    public function test_finance_cost_center_crud_restore_and_force_delete_flow(): void
    {
        $this->authenticate();
        $context = $this->createFinanceContext();

        $createResponse = $this->postJson(self::API_PREFIX.'/cost-centers', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_code' => 'CC-API-001',
            'cost_center_name' => 'API Cost Center',
            'cost_center_type' => 'Culture Cycle',
            'effective_from' => '2026-07-01',
            'effective_to' => null,
            'status' => 'Active',
            'description' => 'Finance API test cost center',
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.cost_center_code', 'CC-API-001');

        $uuid = $createResponse->json('data.uuid');

        $this->getJson(self::API_PREFIX."/cost-centers/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.cost_center_name', 'API Cost Center');

        $this->putJson(self::API_PREFIX."/cost-centers/{$uuid}", [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_code' => 'CC-API-001',
            'cost_center_name' => 'API Cost Center Updated',
            'cost_center_type' => 'Culture Cycle',
            'effective_from' => '2026-07-01',
            'effective_to' => null,
            'status' => 'Active',
            'description' => 'Updated finance API test cost center',
        ])->assertOk()
            ->assertJsonPath('data.cost_center_name', 'API Cost Center Updated');

        $this->deleteJson(self::API_PREFIX."/cost-centers/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted('finance_cost_centers', ['uuid' => $uuid]);

        $this->postJson(self::API_PREFIX."/cost-centers/{$uuid}/restore")
            ->assertOk()
            ->assertJsonPath('message', 'Data restored successfully');

        $this->deleteJson(self::API_PREFIX."/cost-centers/{$uuid}")
            ->assertOk();

        $this->deleteJson(self::API_PREFIX."/cost-centers/{$uuid}/force")
            ->assertOk()
            ->assertJsonPath('message', 'Data permanently deleted');

        $this->assertDatabaseMissing('finance_cost_centers', ['uuid' => $uuid]);
    }

    public function test_finance_operational_api_resources_can_be_created(): void
    {
        $this->authenticate();
        $context = $this->createFinanceContext();
        $costCenter = $this->createCostCenter($context);

        $expenseResponse = $this->postJson(self::API_PREFIX.'/expenses', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'expense_category_id' => $context['expense_category']->id,
            'supplier_id' => $context['supplier']->id,
            'user_id' => $this->user->id,
            'expense_number' => 'EXP-API-001',
            'document_number' => 'DOC-EXP-API-001',
            'expense_date' => '2026-07-10',
            'expense_type' => 'Feed',
            'payment_method' => 'Cash',
            'amount' => 1000000,
            'tax_amount' => 0,
            'total_amount' => 1000000,
            'currency' => 'IDR',
            'status' => 'Draft',
        ]);

        $expenseResponse->assertCreated()
            ->assertJsonPath('data.expense_number', 'EXP-API-001');

        $revenueResponse = $this->postJson(self::API_PREFIX.'/revenues', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'revenue_category_id' => $context['revenue_category']->id,
            'customer_id' => $context['customer']->id,
            'user_id' => $this->user->id,
            'revenue_number' => 'REV-API-001',
            'document_number' => 'DOC-REV-API-001',
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
        ]);

        $revenueResponse->assertCreated()
            ->assertJsonPath('data.revenue_number', 'REV-API-001');

        $journalResponse = $this->postJson(self::API_PREFIX.'/journals', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'user_id' => $this->user->id,
            'journal_number' => 'JRN-API-001',
            'document_number' => 'DOC-JRN-API-001',
            'journal_date' => '2026-07-12',
            'journal_type' => 'General',
            'total_debit' => 0,
            'total_credit' => 0,
            'status' => 'Draft',
            'description' => 'API journal',
        ]);

        $journalResponse->assertCreated()
            ->assertJsonPath('data.journal_number', 'JRN-API-001');

        $ledgerResponse = $this->postJson(self::API_PREFIX.'/ledgers', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'expense_id' => $expenseResponse->json('data.id'),
            'journal_id' => $journalResponse->json('data.id'),
            'ledger_number' => 'LDG-API-001',
            'document_number' => 'DOC-LDG-API-001',
            'ledger_date' => '2026-07-12',
            'ledger_type' => 'Expense',
            'account_code' => '5100',
            'account_name' => 'Feed Cost',
            'debit_amount' => 1000000,
            'credit_amount' => 0,
            'balance_amount' => 1000000,
            'currency' => 'IDR',
            'status' => 'Draft',
            'description' => 'API ledger',
        ]);

        $ledgerResponse->assertCreated()
            ->assertJsonPath('data.ledger_number', 'LDG-API-001');

        $this->postJson(self::API_PREFIX.'/journal-entries', [
            'journal_id' => $journalResponse->json('data.id'),
            'ledger_id' => $ledgerResponse->json('data.id'),
            'cost_center_id' => $costCenter->id,
            'account_code' => '5100',
            'account_name' => 'Feed Cost',
            'entry_type' => 'Debit',
            'debit_amount' => 1000000,
            'credit_amount' => 0,
            'line_order' => 1,
        ])->assertCreated()
            ->assertJsonPath('data.entry_type', 'Debit');

        $this->postJson(self::API_PREFIX.'/cost-allocations', [
            'ledger_id' => $ledgerResponse->json('data.id'),
            'source_cost_center_id' => $costCenter->id,
            'target_cost_center_id' => $costCenter->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'allocation_number' => 'ALLOC-API-001',
            'allocation_date' => '2026-07-13',
            'allocation_method' => 'Percentage',
            'allocation_percentage' => 100,
            'allocated_amount' => 1000000,
            'status' => 'Draft',
        ])->assertCreated()
            ->assertJsonPath('data.allocation_number', 'ALLOC-API-001');

        $this->postJson(self::API_PREFIX.'/profit-calculations', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'calculation_number' => 'PROFIT-API-001',
            'calculation_date' => '2026-07-14',
            'period_start' => '2026-07-01',
            'period_end' => '2026-07-31',
            'status' => 'Draft',
        ])->assertCreated()
            ->assertJsonPath('data.calculation_number', 'PROFIT-API-001');

        $this->postJson(self::API_PREFIX.'/financial-summaries', [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_id' => $costCenter->id,
            'summary_number' => 'SUM-API-001',
            'summary_type' => 'Monthly',
            'period_start' => '2026-07-01',
            'period_end' => '2026-07-31',
            'status' => 'Draft',
        ])->assertCreated()
            ->assertJsonPath('data.summary_number', 'SUM-API-001');
    }

    public function test_finance_validation_rejects_missing_required_fields(): void
    {
        $this->authenticate();

        $this->postJson(self::API_PREFIX.'/expenses', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'company_id',
                'cost_center_id',
                'expense_number',
                'document_number',
                'expense_date',
                'expense_type',
                'amount',
                'status',
            ]);
    }

    public function test_unauthenticated_user_cannot_access_finance_api(): void
    {
        $this->getJson(self::API_PREFIX.'/cost-centers')
            ->assertUnauthorized();
    }

    private function authenticate(): void
    {
        Sanctum::actingAs($this->user);
    }

    private function createCostCenter(array $context): FinanceCostCenter
    {
        return FinanceCostCenter::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'cost_center_code' => 'CC-CTX-001',
            'cost_center_name' => 'Context Cost Center',
            'cost_center_type' => 'Culture Cycle',
            'effective_from' => '2026-07-01',
            'status' => 'Active',
        ]);
    }

    private function createFinanceContext(): array
    {
        $company = Company::query()->create([
            'company_code' => 'CMP-FAPI',
            'company_name' => 'Finance API Company',
        ]);

        $farm = Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-FAPI',
            'farm_name' => 'Finance API Farm',
        ]);

        $pondArea = PondArea::query()->create([
            'farm_id' => $farm->id,
            'pond_area_code' => 'PA-FAPI',
            'pond_area_name' => 'Finance API Pond Area',
        ]);

        $pond = Pond::query()->create([
            'pond_area_id' => $pondArea->id,
            'pond_code' => 'PND-FAPI',
            'pond_name' => 'Finance API Pond',
        ]);

        $fishSpecies = FishSpecies::query()->create([
            'fish_species_code' => 'FSP-FAPI',
            'fish_species_name' => 'Finance API Species',
        ]);

        $fishStrain = FishStrain::query()->create([
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_code' => 'FST-FAPI',
            'fish_strain_name' => 'Finance API Strain',
        ]);

        $supplier = Supplier::query()->create([
            'supplier_code' => 'SUP-FAPI',
            'supplier_name' => 'Finance API Supplier',
            'supplier_type' => 'operational',
        ]);

        $employee = Employee::query()->create([
            'employee_code' => 'EMP-FAPI',
            'employee_name' => 'Finance API Employee',
            'is_active' => true,
        ]);

        $customer = Customer::query()->create([
            'customer_code' => 'CUS-FAPI',
            'customer_name' => 'Finance API Customer',
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
            'cycle_code' => 'CYC-FAPI',
            'cycle_name' => 'Finance API Cycle',
            'status' => 'Active',
        ]);

        $expenseCategory = GeneralReference::query()->create([
            'reference_code' => 'FIN-EXP-API',
            'reference_name' => 'Finance Expense API',
            'reference_group' => 'finance_expense_category',
            'reference_value' => 'Feed',
            'is_active' => true,
        ]);

        $revenueCategory = GeneralReference::query()->create([
            'reference_code' => 'FIN-REV-API',
            'reference_name' => 'Finance Revenue API',
            'reference_group' => 'finance_revenue_category',
            'reference_value' => 'Harvest',
            'is_active' => true,
        ]);

        return [
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
