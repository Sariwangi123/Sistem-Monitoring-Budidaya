<?php

namespace Tests\Feature\Dashboard;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;
use Tests\TestCase;

final class DashboardApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1/dashboard';

    public function test_super_admin_can_access_dashboard_rest_api_contract(): void
    {
        $this->authenticateAs('super-admin');

        foreach ([
            '/',
            '/workspace',
            '/executive',
            '/production',
            '/inventory',
            '/harvest',
            '/finance',
            '/system',
            '/kpi',
            '/widgets',
            '/alerts',
            '/timeline',
            '/analytics',
            '/cache/status',
            '/statistics',
            '/export?format=csv',
        ] as $endpoint) {
            $this->getJson(self::API_PREFIX.$endpoint)
                ->assertOk()
                ->assertJsonPath('success', true);
        }

        $this->postJson(self::API_PREFIX.'/refresh')
            ->assertOk()
            ->assertJsonPath('data.cache_cleared', true);

        $this->deleteJson(self::API_PREFIX.'/cache')
            ->assertOk()
            ->assertJsonPath('data.cache_cleared', true);
    }

    public function test_dashboard_applies_workspace_role_access(): void
    {
        $this->authenticateAs('farm-manager');

        $this->getJson(self::API_PREFIX.'/production')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->getJson(self::API_PREFIX.'/finance')
            ->assertForbidden();

        $this->deleteJson(self::API_PREFIX.'/cache')
            ->assertForbidden();
    }

    public function test_unauthenticated_user_cannot_access_dashboard_api(): void
    {
        $this->getJson(self::API_PREFIX)
            ->assertUnauthorized();
    }

    private function authenticateAs(string $roleSlug): void
    {
        $user = User::query()->create([
            'name' => 'Dashboard Tester',
            'email' => $roleSlug.'@dashboard.test',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $role = Role::query()->create([
            'name' => str($roleSlug)->headline()->toString(),
            'slug' => $roleSlug,
        ]);

        $user->roles()->syncWithoutDetaching([$role->id]);

        Sanctum::actingAs($user);
    }
}
