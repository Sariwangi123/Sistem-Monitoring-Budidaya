<?php

namespace Tests\Unit\Administration;

use Modules\Administration\Engines\AdministrationEngine;
use Modules\Administration\Engines\ConfigurationEngine;
use Modules\Administration\Exceptions\ConfigurationNotFoundException;
use Modules\Administration\Services\ConfigurationValidator;
use Modules\Administration\Support\FeatureToggle;
use Modules\Administration\Support\ModuleRegistry;
use Tests\TestCase;

final class AdministrationEngineTest extends TestCase
{
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
    }

    public function test_configuration_validator_accepts_registered_categories_and_rejects_unknown_categories(): void
    {
        app(ConfigurationEngine::class)->validate('security', ['enabled' => true]);

        $this->expectException(ConfigurationNotFoundException::class);

        app(ConfigurationValidator::class)->validate('unknown');
    }

    public function test_module_registry_exposes_feature_toggle_foundation(): void
    {
        $modules = app(ModuleRegistry::class)->definitions();

        $this->assertSame(FeatureToggle::ENABLED, $modules[0]['toggle']);
        $this->assertSame(FeatureToggle::DISABLED, $modules[7]['toggle']);
        $this->assertSame(FeatureToggle::HIDDEN, $modules[8]['toggle']);
    }
}
