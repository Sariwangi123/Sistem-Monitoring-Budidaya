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
        //
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

        Gate::before(function (User $user): ?bool {
            return $user->roles()->where('slug', 'super-admin')->exists() ? true : null;
        });
    }
}