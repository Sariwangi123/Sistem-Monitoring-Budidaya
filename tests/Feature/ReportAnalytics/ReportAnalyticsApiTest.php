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
            '/report-registry',
            '/report-registry/executive-summary',
            '/operational',
            '/production',
            '/inventory',
            '/harvest',
            '/finance',
            '/executive',
            '/kpi',
            '/audit',
            '/historical',
            '/comparative',
            '/analytics',
            '/export/executive-summary',
            '/schedules',
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

    public function test_report_analytics_generate_and_schedule_contracts(): void
    {
        $this->authenticateAs('super-admin');

        $this->postJson(self::API_PREFIX.'/generate', [
            'report_type' => 'executive-summary',
            'template' => 'executive-summary',
            'export_format' => 'json',
            'locale' => 'id',
            'filter' => [
                'period' => 'monthly',
            ],
            'parameter' => [
                'preview' => true,
            ],
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.definition.id', 'executive-summary')
            ->assertJsonPath('data.export.production_file_export', false)
            ->assertJsonPath('data.queue.queue_enabled', true)
            ->assertJsonPath('data.cache.enabled', true)
            ->assertJsonPath('data.retry.retryable', true)
            ->assertJsonPath('meta.generate_never_store', true);

        $this->postJson(self::API_PREFIX.'/schedules', [
            'report_id' => 'executive-summary',
            'frequency' => 'monthly',
            'export_format' => 'pdf',
            'timezone' => 'Asia/Jakarta',
            'filters' => [
                'period' => 'monthly',
            ],
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.status', 'Accepted')
            ->assertJsonPath('data.lifecycle_status', 'active')
            ->assertJsonPath('data.queue_status', 'pending')
            ->assertJsonPath('data.production_scheduler', false);

        $this->deleteJson(self::API_PREFIX.'/schedules/'.(string) str()->uuid())
            ->assertOk()
            ->assertJsonPath('data.deleted', true)
            ->assertJsonPath('data.production_scheduler', false);
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

        $this->getJson(self::API_PREFIX.'/audit')
            ->assertForbidden();

        $this->getJson(self::API_PREFIX.'/report-registry/audit-trail')
            ->assertForbidden();
    }

    public function test_report_analytics_applies_export_and_schedule_role_access(): void
    {
        $this->authenticateAs('viewer');

        $this->getJson(self::API_PREFIX.'/executive')
            ->assertOk()
            ->assertJsonPath('data.category', 'executive');

        $this->getJson(self::API_PREFIX.'/export/executive-summary')
            ->assertForbidden();

        $this->getJson(self::API_PREFIX.'/schedules')
            ->assertForbidden();
    }

    public function test_report_analytics_validates_generate_payload(): void
    {
        $this->authenticateAs('super-admin');

        $this->postJson(self::API_PREFIX.'/generate', [
            'report_type' => 'missing-report',
            'export_format' => 'exe',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['report_type', 'export_format']);
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
