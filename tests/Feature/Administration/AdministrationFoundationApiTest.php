<?php

namespace Tests\Feature\Administration;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;
use Tests\TestCase;

final class AdministrationFoundationApiTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Cache::forget('administration:configuration:security');
        Cache::forget('administration:configuration-registry:v1');
        Cache::forget('administration:feature-toggle:monitoring');
        Cache::forget('administration:module-registry:v1');

        parent::tearDown();
    }

    public function test_administrator_can_access_system_administration_foundation_overview(): void
    {
        $this->authenticateAs('administrator');

        $this->getJson('/api/v1/admin/overview')->assertOk()
            ->assertJsonPath('success', true)->assertJsonPath('data.module.key', 'system-administration')
            ->assertJsonPath('data.module.read_only_business_module', true)
            ->assertJsonPath('data.configuration_categories.0.key', 'general')
            ->assertJsonPath('data.capabilities.0.key', 'configuration_registry')
            ->assertJsonPath('data.backup_restore.backup.production_operations_enabled', false)
            ->assertJsonPath('data.configuration_engine.single_source_of_truth', true)
            ->assertJsonPath('data.engine_metrics.business_module_direct_access', false)
            ->assertJsonPath('data.engine_metrics.performance.feature_cache', true)
            ->assertJsonPath('data.health.status', 'ready')
            ->assertJsonPath('meta.business_transaction_management_enabled', false);
    }

    public function test_user_without_administration_access_cannot_view_overview(): void
    {
        $this->authenticateAs('viewer');

        $this->getJson('/api/v1/admin/overview')->assertForbidden();
    }

    public function test_administrator_can_access_administration_rest_api_and_update_platform_metadata(): void
    {
        $this->authenticateAs('administrator');

        foreach (['/configurations', '/configurations/security', '/modules', '/modules/monitoring', '/features', '/health', '/health/database', '/health/cache', '/health/storage', '/health/queue', '/security', '/security/permissions', '/security/roles', '/monitoring', '/monitoring/application', '/monitoring/cache', '/monitoring/database', '/monitoring/queue', '/audit', '/audit/statistics', '/backup', '/backup/history', '/integration'] as $endpoint) {
            $this->getJson('/api/v1/admin'.$endpoint)->assertOk()->assertJsonPath('success', true);
        }

        $this->putJson('/api/v1/admin/configurations/security', ['enabled' => false, 'values' => ['password_min_length' => 12]])->assertOk()->assertJsonPath('data.enabled', false);
        $this->getJson('/api/v1/admin/configurations/security')->assertOk()->assertJsonPath('data.values.password_min_length', 12);
        $this->putJson('/api/v1/admin/features/monitoring', ['state' => 'hidden'])->assertOk()->assertJsonPath('data.state', 'hidden');
        $this->getJson('/api/v1/admin/features')->assertOk()->assertJsonPath('data.6.state', 'hidden');
    }

    public function test_unauthenticated_user_cannot_access_administration_overview(): void
    {
        $this->getJson('/api/v1/admin/overview')->assertUnauthorized();
    }

    private function authenticateAs(string $roleSlug): void
    {
        $user = User::query()->create(['name' => 'Administration Tester', 'email' => $roleSlug.'@administration.test', 'password' => Hash::make('password'), 'is_active' => true]);
        $role = Role::query()->create(['name' => str($roleSlug)->headline()->toString(), 'slug' => $roleSlug]);
        $user->roles()->syncWithoutDetaching([$role->id]);
        Sanctum::actingAs($user);
    }
}
