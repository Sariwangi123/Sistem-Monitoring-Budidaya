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
        Cache::forget('administration:configuration-history:security');
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
            ->assertJsonPath('data.health.status', 'healthy')
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

        foreach (['/configurations', '/configurations/security', '/modules', '/modules/monitoring', '/features', '/health', '/health-score', '/health/database', '/health/cache', '/health/storage', '/health/queue', '/security', '/security/governance', '/security/health', '/security/incidents', '/security/incidents/statistics', '/security/alerts', '/security/permissions', '/security/roles', '/monitoring', '/monitoring/summary', '/monitoring/performance', '/monitoring/capacity', '/monitoring/alerts', '/monitoring/application', '/monitoring/cache', '/monitoring/database', '/monitoring/queue', '/monitoring/worker', '/monitoring/scheduler', '/monitoring/api', '/monitoring/integration', '/audit', '/audit/center', '/audit/statistics', '/operational-dashboard', '/backup', '/backup/policy', '/backup/plans', '/backup/history', '/backup/execution', '/backup/verification', '/restore/requests', '/restore/validation', '/disaster-recovery/plan', '/disaster-recovery/readiness', '/disaster-recovery/checklist', '/integration'] as $endpoint) {
            $this->getJson('/api/v1/admin'.$endpoint)->assertOk()->assertJsonPath('success', true);
        }

        $this->putJson('/api/v1/admin/configurations/security', ['enabled' => false, 'values' => ['password_min_length' => 12, 'api_secret' => 'plain-secret'], 'reason' => 'Part 6 test', 'change_summary' => 'Security configuration governance update'])->assertOk()->assertJsonPath('data.enabled', false);
        $this->getJson('/api/v1/admin/configurations/security')->assertOk()->assertJsonPath('data.values.password_min_length', 12);
        $this->getJson('/api/v1/admin/configurations/security/versions')->assertOk()->assertJsonPath('data.0.version', 1);
        $this->getJson('/api/v1/admin/configurations/security/history')->assertOk()->assertJsonPath('data.0.immutable', true)->assertJsonPath('data.0.new_value.values.api_secret', '********');
        $this->getJson('/api/v1/admin/configurations/security/publish')->assertOk()->assertJsonPath('data.status', 'ready');
        $this->getJson('/api/v1/admin/configurations/security/rollback')->assertOk()->assertJsonPath('data.available', true);
        $this->postJson('/api/v1/admin/configurations/security/refresh-cache')->assertOk()->assertJsonPath('data.refreshed', true);
        $this->putJson('/api/v1/admin/features/monitoring', ['state' => 'hidden'])->assertOk()->assertJsonPath('data.state', 'hidden');
        $this->getJson('/api/v1/admin/features')->assertOk()->assertJsonPath('data.6.state', 'hidden');
        $this->getJson('/api/v1/admin/monitoring/performance')->assertOk()->assertJsonPath('data.external_apm_enabled', false);
        $this->getJson('/api/v1/admin/monitoring/capacity')->assertOk()->assertJsonPath('data.planning_mode', 'rule_based_metadata');
        $this->getJson('/api/v1/admin/monitoring/alerts')->assertOk()->assertJsonPath('data.notification_event_engine.uses_existing_engine', true);
        $this->getJson('/api/v1/admin/audit/center')->assertOk()->assertJsonPath('data.immutable', true);
        $this->getJson('/api/v1/admin/health-score')->assertOk()->assertJsonPath('data.scoring.rule_based', true);
        $this->getJson('/api/v1/admin/security/governance')->assertOk()->assertJsonPath('data.policy.auto_remediation', false);
        $this->getJson('/api/v1/admin/security/health')->assertOk()->assertJsonPath('data.rule_based', true);
        $this->getJson('/api/v1/admin/backup/execution')->assertOk()->assertJsonPath('data.destructive_operation', false);
        $this->getJson('/api/v1/admin/backup/verification')->assertOk()->assertJsonPath('data.encryption.plaintext_secret_allowed', false);
        $this->getJson('/api/v1/admin/restore/requests')->assertOk()->assertJsonPath('data.requires_explicit_authorization', true);
        $this->postJson('/api/v1/admin/restore/dry-run')->assertOk()->assertJsonPath('data.destructive_operation', false);
        $this->getJson('/api/v1/admin/disaster-recovery/readiness')->assertOk()->assertJsonPath('data.rule_based', true);
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
