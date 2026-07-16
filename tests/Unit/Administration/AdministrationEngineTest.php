<?php

namespace Tests\Unit\Administration;

use Illuminate\Support\Facades\Cache;
use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Engines\ConfigurationEngine;
use Modules\Administration\Engines\SecurityEngine;
use Modules\Administration\Exceptions\AdministrationException;
use Modules\Administration\Exceptions\ConfigurationNotFoundException;
use Modules\Administration\Services\FeatureToggleService;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Support\FeatureToggle;
use Modules\Administration\Support\ModuleRegistry;
use Tests\TestCase;

final class AdministrationEngineTest extends TestCase
{
    protected function tearDown(): void
    {
        Cache::forget('administration:configuration:security');
        Cache::forget('administration:configuration-registry:v1');
        Cache::forget('administration:feature-toggle:monitoring');
        Cache::forget('administration:module-registry:v1');

        parent::tearDown();
    }

    public function test_administration_engine_orchestrates_platform_metadata(): void
    {
        $overview = app(AdministrationEngine::class)->overview();

        $this->assertTrue($overview['configuration']['single_source_of_truth']);
        $this->assertSame('sanctum', $overview['security']['authentication']);
        $this->assertTrue($overview['monitoring']['read_only']);
        $this->assertTrue($overview['audit']['immutable']);
        $this->assertFalse($overview['backup']['production_operations_enabled']);
        $this->assertFalse($overview['integration']['external_integrations_enabled']);
        $this->assertSame('ready', $overview['health']['status']);
        $this->assertFalse($overview['metrics']['business_module_direct_access']);
        $this->assertTrue($overview['metrics']['performance']['user_scoped_cache']);
    }

    public function test_configuration_validator_accepts_registered_categories_and_rejects_unknown_categories(): void
    {
        app(ConfigurationEngine::class)->validate('security', ['enabled' => true]);

        $this->expectException(ConfigurationNotFoundException::class);

        app(ConfigurationValidator::class)->validate('unknown');
    }

    public function test_administration_exceptions_share_base_exception_hierarchy(): void
    {
        $this->assertInstanceOf(AdministrationException::class, ConfigurationNotFoundException::forCategory('unknown'));
    }

    public function test_configuration_update_uses_cache_strategy_and_synchronization_metadata(): void
    {
        $engine = app(ConfigurationEngine::class);
        $updated = $engine->update('security', ['enabled' => false, 'values' => ['password_min_length' => 12]]);
        $metadata = $engine->metadata();

        $this->assertFalse($updated['enabled']);
        $this->assertSame(12, $engine->configuration('security')['values']['password_min_length']);
        $this->assertSame('cache_invalidation_on_update', $metadata['synchronization']);
        $this->assertContains('feature', $metadata['cache']['scopes']);
    }

    public function test_feature_toggle_service_evaluates_cached_feature_state(): void
    {
        $service = app(FeatureToggleService::class);

        $this->assertTrue($service->enabled('monitoring'));
        $service->update('monitoring', FeatureToggle::HIDDEN);

        $this->assertFalse($service->enabled('monitoring'));
        $this->assertSame('feature', collect($service->all())->firstWhere('key', 'monitoring')['cache_scope']);
    }

    public function test_security_engine_reports_cached_role_and_permission_evaluation(): void
    {
        $metadata = app(SecurityEngine::class)->metadata();

        $this->assertSame('user_scoped_cache', $metadata['role_resolution']);
        $this->assertSame('user_scoped_cache', $metadata['permission_evaluation']);
        $this->assertTrue($metadata['least_privilege']);
    }

    public function test_module_registry_exposes_feature_toggle_foundation(): void
    {
        $modules = app(ModuleRegistry::class)->definitions();

        $this->assertSame(FeatureToggle::ENABLED, $modules[0]['toggle']);
        $this->assertSame(FeatureToggle::DISABLED, $modules[7]['toggle']);
        $this->assertSame(FeatureToggle::HIDDEN, $modules[8]['toggle']);
    }
}
