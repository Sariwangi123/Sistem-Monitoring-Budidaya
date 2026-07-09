<?php

namespace Database\Seeders;

use Database\Seeders\CultureCycle\CultureCycleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\Permissions\Models\Permission;
use Modules\Roles\Models\Role;
use Modules\Settings\Models\GlobalSetting;
use Modules\Users\Models\User;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = collect([
            'users.manage',
            'roles.manage',
            'permissions.manage',
            'settings.manage',
            'notifications.manage',
        ])->map(fn (string $slug) => Permission::query()->firstOrCreate(
            ['slug' => $slug],
            ['uuid' => (string) Str::uuid(), 'name' => Str::headline($slug)]
        ));

        $roles = collect([
            'super-admin' => 'Super Admin',
            'farm-owner' => 'Farm Owner',
            'farm-manager' => 'Farm Manager',
            'technician' => 'Technician',
            'warehouse-staff' => 'Warehouse Staff',
            'finance-staff' => 'Finance Staff',
            'viewer' => 'Viewer',
        ])->map(fn (string $name, string $slug) => Role::query()->firstOrCreate(
            ['slug' => $slug],
            ['uuid' => (string) Str::uuid(), 'name' => $name]
        ));

        $roles->firstWhere('slug', 'super-admin')?->permissions()->sync($permissions->pluck('id'));

        $admin = User::query()->firstOrCreate(
            ['email' => 'admin@utifarm.local'],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'UtiFarm Admin',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        $admin->roles()->syncWithoutDetaching([$roles->firstWhere('slug', 'super-admin')?->id]);

        collect([
            'timezone' => ['value' => 'Asia/Jakarta', 'type' => 'string'],
            'currency' => ['value' => 'IDR', 'type' => 'string'],
            'weight_unit' => ['value' => 'kg', 'type' => 'string'],
            'length_unit' => ['value' => 'cm', 'type' => 'string'],
            'language' => ['value' => 'id', 'type' => 'string'],
            'company_profile' => ['value' => ['name' => 'UtiFarm'], 'type' => 'json'],
        ])->each(fn (array $setting, string $key) => GlobalSetting::query()->firstOrCreate(
            ['key' => $key],
            ['uuid' => (string) Str::uuid(), 'value' => $setting['value'], 'type' => $setting['type']]
        ));

        $this->call(CultureCycleSeeder::class);
    }
}
