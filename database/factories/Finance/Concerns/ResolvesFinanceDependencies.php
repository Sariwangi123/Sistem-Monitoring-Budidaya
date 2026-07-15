<?php

namespace Database\Factories\Finance\Concerns;

use Activities\Models\Activity;
use CultureCycle\Models\CultureCycle;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceExpense;
use Finance\Models\FinanceJournal;
use Finance\Models\FinanceLedger;
use Finance\Models\FinanceRevenue;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestDelivery;
use Illuminate\Support\Facades\Hash;
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

trait ResolvesFinanceDependencies
{
    protected function companyId(): int
    {
        return Company::query()->firstOrCreate(
            ['company_code' => 'CMP-FIN'],
            ['company_name' => 'Finance Company']
        )->id;
    }

    protected function farmId(): int
    {
        return Farm::query()->firstOrCreate(
            ['farm_code' => 'FRM-FIN'],
            ['company_id' => $this->companyId(), 'farm_name' => 'Finance Farm']
        )->id;
    }

    protected function pondAreaId(): int
    {
        return PondArea::query()->firstOrCreate(
            ['pond_area_code' => 'AREA-FIN'],
            ['farm_id' => $this->farmId(), 'pond_area_name' => 'Finance Pond Area']
        )->id;
    }

    protected function pondId(): int
    {
        return Pond::query()->firstOrCreate(
            ['pond_code' => 'PND-FIN'],
            [
                'pond_area_id' => $this->pondAreaId(),
                'pond_name' => 'Finance Pond',
                'area_size' => 1000,
                'depth' => 1.5,
                'volume' => 1500,
            ]
        )->id;
    }

    protected function fishSpeciesId(): int
    {
        return FishSpecies::query()->firstOrCreate(
            ['fish_species_code' => 'FSP-FIN'],
            ['fish_species_name' => 'Tilapia', 'scientific_name' => 'Oreochromis niloticus']
        )->id;
    }

    protected function fishStrainId(): int
    {
        return FishStrain::query()->firstOrCreate(
            ['fish_strain_code' => 'FSR-FIN'],
            ['fish_species_id' => $this->fishSpeciesId(), 'fish_strain_name' => 'Nirwana Finance']
        )->id;
    }

    protected function supplierId(): int
    {
        return Supplier::query()->firstOrCreate(
            ['supplier_code' => 'SUP-FIN'],
            ['supplier_name' => 'Finance Supplier', 'supplier_type' => 'operational']
        )->id;
    }

    protected function customerId(): int
    {
        return Customer::query()->firstOrCreate(
            ['customer_code' => 'CUST-FIN'],
            ['customer_name' => 'Finance Customer', 'customer_type' => 'corporate']
        )->id;
    }

    protected function employeeId(): int
    {
        return Employee::query()->firstOrCreate(
            ['employee_code' => 'EMP-FIN'],
            [
                'employee_name' => 'Finance Technician',
                'position' => 'Technician',
                'department' => 'Production',
                'is_active' => true,
            ]
        )->id;
    }

    protected function userId(): int
    {
        return User::query()->firstOrCreate(
            ['email' => 'finance.user@example.com'],
            ['name' => 'Finance User', 'password' => Hash::make('password'), 'is_active' => true]
        )->id;
    }

    protected function cultureCycleId(): int
    {
        return CultureCycle::query()->firstOrCreate(
            ['cycle_code' => 'CYC-FIN'],
            [
                'uuid' => (string) Str::uuid(),
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_area_id' => $this->pondAreaId(),
                'pond_id' => $this->pondId(),
                'fish_species_id' => $this->fishSpeciesId(),
                'fish_strain_id' => $this->fishStrainId(),
                'supplier_id' => $this->supplierId(),
                'employee_id' => $this->employeeId(),
                'cycle_name' => 'Finance Culture Cycle',
                'stocking_date' => now()->subMonths(4)->toDateString(),
                'estimated_harvest_date' => now()->addWeek()->toDateString(),
                'initial_seed_quantity' => 10000,
                'current_population' => 9200,
                'initial_average_weight' => 10,
                'current_average_weight' => 250,
                'current_biomass' => 2300,
                'status' => 'Active',
            ]
        )->id;
    }

    protected function expenseCategoryId(): int
    {
        return GeneralReference::query()->firstOrCreate(
            ['reference_code' => 'FIN-EXP-FEED'],
            [
                'reference_name' => 'Feed Cost',
                'reference_group' => 'finance_expense_category',
                'reference_value' => 'Feed',
                'is_active' => true,
            ]
        )->id;
    }

    protected function revenueCategoryId(): int
    {
        return GeneralReference::query()->firstOrCreate(
            ['reference_code' => 'FIN-REV-HARVEST'],
            [
                'reference_name' => 'Harvest Revenue',
                'reference_group' => 'finance_revenue_category',
                'reference_value' => 'Harvest',
                'is_active' => true,
            ]
        )->id;
    }

    protected function costCenterId(): int
    {
        return FinanceCostCenter::query()->firstOrCreate(
            ['cost_center_code' => 'CC-FIN-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_id' => $this->pondId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'cost_center_name' => 'Main Finance Cost Center',
                'cost_center_type' => 'Culture Cycle',
                'effective_from' => now()->subMonths(4)->toDateString(),
                'status' => 'Active',
            ]
        )->id;
    }

    protected function activityId(): ?int
    {
        return Activity::query()->where('culture_cycle_id', $this->cultureCycleId())->value('id');
    }

    protected function harvestId(): int
    {
        return Harvest::query()->firstOrCreate(
            ['harvest_code' => 'HRV-FIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_area_id' => $this->pondAreaId(),
                'pond_id' => $this->pondId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'customer_id' => $this->customerId(),
                'responsible_user_id' => $this->userId(),
                'harvest_name' => 'Finance Harvest',
                'harvest_type' => 'Final Harvest',
                'planned_harvest_date' => now()->subDay()->toDateString(),
                'harvest_date' => now()->toDateString(),
                'estimated_population' => 2000,
                'estimated_biomass' => 500,
                'total_harvest_population' => 1900,
                'total_harvest_weight' => 475,
                'average_weight' => 0.25,
                'status' => 'Completed',
            ]
        )->id;
    }

    protected function harvestDeliveryId(): ?int
    {
        return HarvestDelivery::query()->where('harvest_id', $this->harvestId())->value('id');
    }

    protected function expenseId(): int
    {
        return FinanceExpense::query()->firstOrCreate(
            ['expense_number' => 'EXP-FIN-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'cost_center_id' => $this->costCenterId(),
                'expense_category_id' => $this->expenseCategoryId(),
                'supplier_id' => $this->supplierId(),
                'user_id' => $this->userId(),
                'document_number' => 'DOC-EXP-FIN-MAIN',
                'expense_date' => now()->toDateString(),
                'expense_type' => 'Feed',
                'amount' => 2500000,
                'tax_amount' => 0,
                'total_amount' => 2500000,
                'currency' => 'IDR',
                'source_type' => 'Warehouse',
                'source_uuid' => (string) Str::uuid(),
                'status' => 'Posted',
            ]
        )->id;
    }

    protected function revenueId(): int
    {
        return FinanceRevenue::query()->firstOrCreate(
            ['revenue_number' => 'REV-FIN-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'cost_center_id' => $this->costCenterId(),
                'revenue_category_id' => $this->revenueCategoryId(),
                'harvest_id' => $this->harvestId(),
                'harvest_delivery_id' => $this->harvestDeliveryId(),
                'customer_id' => $this->customerId(),
                'user_id' => $this->userId(),
                'document_number' => 'DOC-REV-FIN-MAIN',
                'revenue_date' => now()->toDateString(),
                'revenue_type' => 'Harvest',
                'quantity' => 475,
                'unit_price' => 35000,
                'amount' => 16625000,
                'total_amount' => 16625000,
                'currency' => 'IDR',
                'source_type' => 'Harvest',
                'source_uuid' => (string) Str::uuid(),
                'status' => 'Posted',
            ]
        )->id;
    }

    protected function journalId(): int
    {
        return FinanceJournal::query()->firstOrCreate(
            ['journal_number' => 'JRN-FIN-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'user_id' => $this->userId(),
                'document_number' => 'DOC-JRN-FIN-MAIN',
                'journal_date' => now()->toDateString(),
                'journal_type' => 'Operational',
                'total_debit' => 2500000,
                'total_credit' => 2500000,
                'source_type' => 'Finance',
                'source_uuid' => (string) Str::uuid(),
                'status' => 'Posted',
            ]
        )->id;
    }

    protected function ledgerId(): int
    {
        return FinanceLedger::query()->firstOrCreate(
            ['ledger_number' => 'LDG-FIN-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'cost_center_id' => $this->costCenterId(),
                'expense_id' => $this->expenseId(),
                'journal_id' => $this->journalId(),
                'document_number' => 'DOC-LDG-FIN-MAIN',
                'ledger_date' => now()->toDateString(),
                'ledger_type' => 'Expense',
                'account_code' => '5100',
                'account_name' => 'Feed Cost',
                'debit_amount' => 2500000,
                'credit_amount' => 0,
                'balance_amount' => 2500000,
                'currency' => 'IDR',
                'source_type' => 'FinanceExpense',
                'source_uuid' => (string) Str::uuid(),
                'posted_at' => now(),
                'status' => 'Posted',
            ]
        )->id;
    }
}
