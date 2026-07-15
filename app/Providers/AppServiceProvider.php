<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use MasterData\Models\City;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\District;
use MasterData\Models\Employee;
use MasterData\Models\Farm;
use MasterData\Models\FeedBrand;
use MasterData\Models\FeedCategory;
use MasterData\Models\FeedType;
use MasterData\Models\FishSpecies;
use MasterData\Models\FishStrain;
use MasterData\Models\GeneralReference;
use MasterData\Models\Medicine;
use MasterData\Models\Pond;
use MasterData\Models\PondArea;
use MasterData\Models\Probiotic;
use MasterData\Models\Province;
use MasterData\Models\Supplier;
use MasterData\Models\Unit;
use MasterData\Models\Vitamin;
use CultureCycle\Models\CultureCycle;
use CultureCycle\Policies\CultureCyclePolicy;
use Dashboard\Repositories\Contracts\DashboardRepositoryInterface;
use Dashboard\Repositories\DashboardRepository;
use Dashboard\Widgets\WidgetRegistry;
use Finance\Models\FinanceCostAllocation;
use Finance\Models\FinanceCostCenter;
use Finance\Models\FinanceExpense;
use Finance\Models\FinanceFinancialSummary;
use Finance\Models\FinanceJournal;
use Finance\Models\FinanceJournalEntry;
use Finance\Models\FinanceLedger;
use Finance\Models\FinanceProfitCalculation;
use Finance\Models\FinanceRevenue;
use Finance\Policies\FinanceCostAllocationPolicy;
use Finance\Policies\FinanceCostCenterPolicy;
use Finance\Policies\FinanceExpensePolicy;
use Finance\Policies\FinanceFinancialSummaryPolicy;
use Finance\Policies\FinanceJournalEntryPolicy;
use Finance\Policies\FinanceJournalPolicy;
use Finance\Policies\FinanceLedgerPolicy;
use Finance\Policies\FinanceProfitCalculationPolicy;
use Finance\Policies\FinanceRevenuePolicy;
use Finance\Repositories\Contracts\FinanceCostAllocationRepositoryInterface;
use Finance\Repositories\Contracts\FinanceCostCenterRepositoryInterface;
use Finance\Repositories\Contracts\FinanceExpenseRepositoryInterface;
use Finance\Repositories\Contracts\FinanceFinancialSummaryRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalEntryRepositoryInterface;
use Finance\Repositories\Contracts\FinanceJournalRepositoryInterface;
use Finance\Repositories\Contracts\FinanceLedgerRepositoryInterface;
use Finance\Repositories\Contracts\FinanceProfitCalculationRepositoryInterface;
use Finance\Repositories\Contracts\FinanceRevenueRepositoryInterface;
use Finance\Repositories\FinanceCostAllocationRepository;
use Finance\Repositories\FinanceCostCenterRepository;
use Finance\Repositories\FinanceExpenseRepository;
use Finance\Repositories\FinanceFinancialSummaryRepository;
use Finance\Repositories\FinanceJournalEntryRepository;
use Finance\Repositories\FinanceJournalRepository;
use Finance\Repositories\FinanceLedgerRepository;
use Finance\Repositories\FinanceProfitCalculationRepository;
use Finance\Repositories\FinanceRevenueRepository;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestDelivery;
use Harvest\Models\HarvestGrade;
use Harvest\Models\HarvestPacking;
use Harvest\Models\HarvestQualityControl;
use Harvest\Policies\HarvestBatchPolicy;
use Harvest\Policies\HarvestDeliveryPolicy;
use Harvest\Policies\HarvestGradePolicy;
use Harvest\Policies\HarvestPackingPolicy;
use Harvest\Policies\HarvestPolicy;
use Harvest\Policies\HarvestQualityControlPolicy;
use Harvest\Repositories\Contracts\HarvestBatchRepositoryInterface;
use Harvest\Repositories\Contracts\HarvestDeliveryRepositoryInterface;
use Harvest\Repositories\Contracts\HarvestGradeRepositoryInterface;
use Harvest\Repositories\Contracts\HarvestPackingRepositoryInterface;
use Harvest\Repositories\Contracts\HarvestQualityControlRepositoryInterface;
use Harvest\Repositories\Contracts\HarvestRepositoryInterface;
use Harvest\Repositories\HarvestBatchRepository;
use Harvest\Repositories\HarvestDeliveryRepository;
use Harvest\Repositories\HarvestGradeRepository;
use Harvest\Repositories\HarvestPackingRepository;
use Harvest\Repositories\HarvestQualityControlRepository;
use Harvest\Repositories\HarvestRepository;
use MasterData\Models\Village;
use MasterData\Policies\MasterDataPolicy;
use Modules\Notifications\Models\NotificationTemplate;
use Modules\Notifications\Observers\NotificationTemplateObserver;
use Modules\Permissions\Models\Permission;
use Modules\Permissions\Observers\PermissionObserver;
use Modules\Roles\Models\Role;
use Modules\Roles\Observers\RoleObserver;
use Modules\Settings\Models\GlobalSetting;
use Modules\Settings\Observers\GlobalSettingObserver;
use Modules\Users\Models\User;
use Modules\Users\Observers\UserObserver;

final class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(WidgetRegistry::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
        $this->app->bind(HarvestRepositoryInterface::class, HarvestRepository::class);
        $this->app->bind(HarvestBatchRepositoryInterface::class, HarvestBatchRepository::class);
        $this->app->bind(HarvestQualityControlRepositoryInterface::class, HarvestQualityControlRepository::class);
        $this->app->bind(HarvestGradeRepositoryInterface::class, HarvestGradeRepository::class);
        $this->app->bind(HarvestPackingRepositoryInterface::class, HarvestPackingRepository::class);
        $this->app->bind(HarvestDeliveryRepositoryInterface::class, HarvestDeliveryRepository::class);
        $this->app->bind(FinanceCostCenterRepositoryInterface::class, FinanceCostCenterRepository::class);
        $this->app->bind(FinanceExpenseRepositoryInterface::class, FinanceExpenseRepository::class);
        $this->app->bind(FinanceRevenueRepositoryInterface::class, FinanceRevenueRepository::class);
        $this->app->bind(FinanceJournalRepositoryInterface::class, FinanceJournalRepository::class);
        $this->app->bind(FinanceLedgerRepositoryInterface::class, FinanceLedgerRepository::class);
        $this->app->bind(FinanceJournalEntryRepositoryInterface::class, FinanceJournalEntryRepository::class);
        $this->app->bind(FinanceCostAllocationRepositoryInterface::class, FinanceCostAllocationRepository::class);
        $this->app->bind(FinanceProfitCalculationRepositoryInterface::class, FinanceProfitCalculationRepository::class);
        $this->app->bind(FinanceFinancialSummaryRepositoryInterface::class, FinanceFinancialSummaryRepository::class);
    }

    public function boot(): void
    {
        User::observe(UserObserver::class);
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        GlobalSetting::observe(GlobalSettingObserver::class);
        NotificationTemplate::observe(NotificationTemplateObserver::class);

        Gate::policy(Province::class, MasterDataPolicy::class);
        Gate::policy(City::class, MasterDataPolicy::class);
        Gate::policy(District::class, MasterDataPolicy::class);
        Gate::policy(Village::class, MasterDataPolicy::class);
        Gate::policy(Unit::class, MasterDataPolicy::class);
        Gate::policy(Company::class, MasterDataPolicy::class);
        Gate::policy(Farm::class, MasterDataPolicy::class);
        Gate::policy(PondArea::class, MasterDataPolicy::class);
        Gate::policy(Pond::class, MasterDataPolicy::class);
        Gate::policy(FishSpecies::class, MasterDataPolicy::class);
        Gate::policy(FishStrain::class, MasterDataPolicy::class);
        Gate::policy(FeedBrand::class, MasterDataPolicy::class);
        Gate::policy(FeedCategory::class, MasterDataPolicy::class);
        Gate::policy(FeedType::class, MasterDataPolicy::class);
        Gate::policy(Medicine::class, MasterDataPolicy::class);
        Gate::policy(Probiotic::class, MasterDataPolicy::class);
        Gate::policy(Vitamin::class, MasterDataPolicy::class);
        Gate::policy(Supplier::class, MasterDataPolicy::class);
        Gate::policy(Customer::class, MasterDataPolicy::class);
        Gate::policy(Employee::class, MasterDataPolicy::class);
        Gate::policy(GeneralReference::class, MasterDataPolicy::class);
        Gate::policy(CultureCycle::class, CultureCyclePolicy::class);
        Gate::policy(Harvest::class, HarvestPolicy::class);
        Gate::policy(HarvestBatch::class, HarvestBatchPolicy::class);
        Gate::policy(HarvestDelivery::class, HarvestDeliveryPolicy::class);
        Gate::policy(HarvestGrade::class, HarvestGradePolicy::class);
        Gate::policy(HarvestPacking::class, HarvestPackingPolicy::class);
        Gate::policy(HarvestQualityControl::class, HarvestQualityControlPolicy::class);
        Gate::policy(FinanceCostCenter::class, FinanceCostCenterPolicy::class);
        Gate::policy(FinanceExpense::class, FinanceExpensePolicy::class);
        Gate::policy(FinanceRevenue::class, FinanceRevenuePolicy::class);
        Gate::policy(FinanceJournal::class, FinanceJournalPolicy::class);
        Gate::policy(FinanceLedger::class, FinanceLedgerPolicy::class);
        Gate::policy(FinanceJournalEntry::class, FinanceJournalEntryPolicy::class);
        Gate::policy(FinanceCostAllocation::class, FinanceCostAllocationPolicy::class);
        Gate::policy(FinanceProfitCalculation::class, FinanceProfitCalculationPolicy::class);
        Gate::policy(FinanceFinancialSummary::class, FinanceFinancialSummaryPolicy::class);

        Gate::before(function (User $user): ?bool {
            return $user->roles()->where('slug', 'super-admin')->exists() ? true : null;
        });
    }
}
