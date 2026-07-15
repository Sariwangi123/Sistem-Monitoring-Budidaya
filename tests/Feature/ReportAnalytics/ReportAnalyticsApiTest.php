<?php

namespace Tests\Feature\ReportAnalytics;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;
use Tests\TestCase;

final class ReportAnalyticsApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1/reports';

    public function test_super_admin_can_access_report_analytics_foundation(): void
    {
        $this->authenticateAs('super-admin');

        foreach ([
            '',
            '/categories',
            '/workspaces',
        ] as $endpoint) {
            $this->getJson(self::API_PREFIX.$endpoint)
                ->assertOk()
                ->assertJsonPath('success', true)
                ->assertJsonPath('meta.read_only', true)
                ->assertJsonPath('meta.generate_never_store', true);
        }

        $this->getJson(self::API_PREFIX)
            ->assertOk()
            ->assertJsonPath('data.module.key', 'report_analytics')
            ->assertJsonPath('data.module.principle', 'Generate, Never Store')
            ->assertJsonPath('data.module.read_only', true)
            ->assertJsonPath('data.module.stores_transaction_snapshot', false)
            ->assertJsonStructure([
                'data' => [
                    'module',
                    'categories',
                    'workspaces',
                    'data_sources',
                    'constraints',
                    'service_layer',
                    'dashboard_reference',
                ],
            ]);
    }

    public function test_report_analytics_filters_audit_category_by_role(): void
    {
        $this->authenticateAs('finance-staff');

        $response = $this->getJson(self::API_PREFIX.'/categories')
            ->assertOk()
            ->assertJsonPath('success', true);

        $keys = collect($response->json('data.items'))->pluck('key')->all();

        $this->assertContains('financial', $keys);
        $this->assertContains('kpi', $keys);
        $this->assertNotContains('audit', $keys);
    }

    public function test_unauthenticated_user_cannot_access_report_analytics(): void
    {
        $this->getJson(self::API_PREFIX)
            ->assertUnauthorized();
    }

    private function authenticateAs(string $roleSlug): void
    {
        $user = User::query()->create([
            'name' => 'Report Tester',
            'email' => $roleSlug.'@reports.test',
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
