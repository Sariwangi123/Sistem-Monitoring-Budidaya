<?php

namespace Tests\Feature\Dashboard;

use Dashboard\Services\DashboardService;
use Dashboard\Widgets\Contracts\DashboardWidgetInterface;
use Dashboard\Widgets\Support\DashboardWidgetContext;
use Dashboard\Widgets\Support\WidgetDefinition;
use Dashboard\Widgets\WidgetRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
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
            '/intelligence',
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

    public function test_dashboard_cache_reports_hit_and_dashboard_refresh_clears_cache(): void
    {
        Cache::flush();
        $this->authenticateAs('super-admin');

        $this->getJson(self::API_PREFIX.'/kpi')
            ->assertOk()
            ->assertJsonPath('meta.cache_status', 'miss');

        $this->getJson(self::API_PREFIX.'/kpi')
            ->assertOk()
            ->assertJsonPath('meta.cache_status', 'hit');

        $this->postJson(self::API_PREFIX.'/refresh')
            ->assertOk()
            ->assertJsonPath('meta.cache_status', 'cleared');

        $this->getJson(self::API_PREFIX.'/kpi')
            ->assertOk()
            ->assertJsonPath('meta.cache_status', 'miss');
    }

    public function test_widget_engine_isolates_widget_errors_and_filters_by_role(): void
    {
        $registry = app(WidgetRegistry::class);
        $registry->register(new TestDashboardWidget('production-ok', ['farm-manager']));
        $registry->register(new FailingDashboardWidget('production-error', ['farm-manager']));
        $registry->register(new TestDashboardWidget('production-hidden', ['finance-staff']));

        $this->authenticateAs('farm-manager');

        $response = $this->getJson(self::API_PREFIX.'/production');

        $response->assertOk()
            ->assertJsonPath('data.widgets.0.key', 'production-ok')
            ->assertJsonPath('data.widgets.0.status', 'Loaded')
            ->assertJsonPath('data.widgets.1.key', 'production-error')
            ->assertJsonPath('data.widgets.1.status', 'Error');

        $this->assertCount(2, $response->json('data.widgets'));
    }

    public function test_widget_refresh_supports_permission_and_not_found_handling(): void
    {
        app(WidgetRegistry::class)->register(new TestDashboardWidget('production-refresh', ['farm-manager']));
        app(WidgetRegistry::class)->register(new TestDashboardWidget('finance-refresh', ['finance-staff']));

        $this->authenticateAs('farm-manager');

        $this->postJson(self::API_PREFIX.'/widgets/production-refresh/refresh')
            ->assertOk()
            ->assertJsonPath('data.key', 'production-refresh')
            ->assertJsonPath('data.status', 'Loaded')
            ->assertJsonPath('data.meta.lifecycle', 'refreshed');

        $this->postJson(self::API_PREFIX.'/widgets/finance-refresh/refresh')
            ->assertForbidden();

        $this->postJson(self::API_PREFIX.'/widgets/missing-widget/refresh')
            ->assertNotFound();
    }

    public function test_operational_intelligence_returns_rule_based_summary_and_recommendations(): void
    {
        $this->authenticateAs('super-admin');

        $this->getJson(self::API_PREFIX.'/intelligence')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.meta.mode', 'rule_based')
            ->assertJsonPath('data.meta.read_only', true)
            ->assertJsonStructure([
                'data' => [
                    'operational_summary',
                    'kpi_intelligence' => ['items', 'trend', 'comparison'],
                    'trend_indicators',
                    'comparative_indicators',
                    'insight_cards',
                    'recommendations',
                    'farm_health_summary',
                    'pond_health_summary',
                    'financial_health_summary',
                    'inventory_health_summary',
                    'production_health_summary',
                ],
            ]);

        $this->getJson(self::API_PREFIX.'/kpi')
            ->assertOk()
            ->assertJsonPath('data.items.0.key', 'active_cycles');

        $this->getJson(self::API_PREFIX.'/alerts')
            ->assertOk()
            ->assertJsonPath('data.items.0.status', 'Open');
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

class TestDashboardWidget implements DashboardWidgetInterface
{
    public function __construct(
        private string $key,
        private array $allowedRoles = []
    ) {
    }

    public function definition(): WidgetDefinition
    {
        return new WidgetDefinition(
            key: $this->key,
            workspace: str_starts_with($this->key, 'finance') ? 'finance' : 'production',
            title: str($this->key)->headline()->toString(),
            category: 'Test',
            size: 'Medium',
            refreshSeconds: 30,
            component: 'TestWidget',
            requiredPermission: null,
            dataSource: 'Test Service',
            allowedRoles: $this->allowedRoles
        );
    }

    public function load(DashboardService $dashboardService, DashboardWidgetContext $context): array
    {
        return [
            'workspace' => $context->workspace,
            'force_refresh' => $context->forceRefresh,
        ];
    }
}

final class FailingDashboardWidget extends TestDashboardWidget
{
    public function load(DashboardService $dashboardService, DashboardWidgetContext $context): array
    {
        throw new \RuntimeException('Widget test failure.');
    }
}
