<?php

namespace ReportAnalytics\Policies;

use Modules\Users\Models\User;

final class ReportAnalyticsPolicy
{
    /** @var array<int, string> */
    private const ALLOWED_ROLES = [
        'super-admin',
        'farm-owner',
        'director',
        'farm-manager',
        'warehouse-staff',
        'finance-staff',
        'technician',
        'viewer',
    ];

    /** @var array<string, array<int, string>> */
    private const CATEGORY_ROLES = [
        'executive' => ['super-admin', 'farm-owner', 'director', 'viewer'],
        'operational' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician'],
        'production' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician'],
        'inventory' => ['super-admin', 'farm-manager', 'warehouse-staff'],
        'harvest' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'technician'],
        'financial' => ['super-admin', 'farm-owner', 'director', 'finance-staff'],
        'finance' => ['super-admin', 'farm-owner', 'director', 'finance-staff'],
        'kpi' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer'],
        'audit' => ['super-admin'],
        'historical' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer'],
        'comparative' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer'],
        'analytics' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'viewer'],
        'schedule' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff'],
        'export' => ['super-admin', 'farm-owner', 'director', 'farm-manager', 'finance-staff', 'warehouse-staff'],
    ];

    public function view(User $user): bool
    {
        return $user->roles()
            ->whereIn('slug', self::ALLOWED_ROLES)
            ->exists();
    }

    public function viewCategory(User $user, string $category): bool
    {
        return $user->roles()
            ->whereIn('slug', self::CATEGORY_ROLES[$category] ?? [])
            ->exists();
    }

    public function generate(User $user, string $category): bool
    {
        return $this->viewCategory($user, $category);
    }

    public function export(User $user, string $category): bool
    {
        return $this->viewCategory($user, $category)
            && $user->roles()->whereIn('slug', self::CATEGORY_ROLES['export'])->exists();
    }

    public function schedule(User $user): bool
    {
        return $user->roles()
            ->whereIn('slug', self::CATEGORY_ROLES['schedule'])
            ->exists();
    }
}
