<?php

namespace Tests\Unit\ReportAnalytics;

use ReportAnalytics\Builders\ReportBuilder;
use ReportAnalytics\Engines\UniversalReportEngine;
use ReportAnalytics\Formatters\ReportDataFormatter;
use ReportAnalytics\Registry\ReportRegistry;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;
use ReportAnalytics\Templates\TemplateResolver;
use Tests\TestCase;

final class ReportEngineTest extends TestCase
{
    public function test_report_registry_registers_and_filters_definitions(): void
    {
        $registry = new ReportRegistry();
        $registry->register(new ReportDefinition(
            id: 'custom-viewer-report',
            name: 'Custom Viewer Report',
            category: 'executive',
            sourceModule: 'Dashboard',
            template: 'executive-summary',
            requiredPermission: 'view-reports',
            supportedExportFormats: ['json'],
            scheduleSupport: false,
            version: '1.0',
            allowedRoles: ['viewer']
        ));

        $viewerReports = array_map(
            fn (ReportDefinition $definition): string => $definition->id,
            $registry->visibleForRoles(['viewer'])
        );

        $this->assertContains('custom-viewer-report', $viewerReports);
        $this->assertNotContains('audit-trail', $viewerReports);
    }

    public function test_template_resolver_returns_layout_and_sections(): void
    {
        $template = (new TemplateResolver())->resolve('executive-summary');

        $this->assertSame('executive-summary', $template->key);
        $this->assertSame('standard-cover', $template->layout->cover);
        $this->assertContains('executive_summary', $template->sections);
    }

    public function test_builder_uses_collector_and_formatter(): void
    {
        $definition = new ReportDefinition(
            id: 'builder-test',
            name: 'Builder Test',
            category: 'kpi',
            sourceModule: 'Dashboard',
            template: 'kpi-scorecard',
            requiredPermission: 'view-reports',
            supportedExportFormats: ['json'],
            scheduleSupport: false,
            version: '1.0',
            allowedRoles: ['super-admin']
        );
        $template = (new TemplateResolver())->resolve('kpi-scorecard');
        $collector = new class implements \ReportAnalytics\Contracts\DataCollectorInterface {
            public function collect(ReportDefinition $definition, array $parameters = []): array
            {
                return [
                    'source_module' => $definition->sourceModule,
                    'filters' => $parameters,
                    'read_only' => true,
                ];
            }
        };

        $build = (new ReportBuilder($collector, new ReportDataFormatter()))
            ->build($definition, $template, 'id', ['period' => 'monthly']);

        $this->assertSame('builder-test', $build->definition->id);
        $this->assertSame('id', $build->locale);
        $this->assertNotEmpty($build->sections);
        $this->assertTrue($build->sections[0]->data['payload']['read_only']);
    }

    public function test_formatter_supports_locale_aware_foundation(): void
    {
        $formatter = new ReportDataFormatter();

        $this->assertSame('1.500,50', $formatter->number(1500.5, 'id'));
        $this->assertSame('1,500.50', $formatter->number(1500.5, 'en'));
        $this->assertSame('Rp 1.500,50', $formatter->currency(1500.5, 'id'));
        $this->assertSame('12,50%', $formatter->percentage(12.5, 'id'));
    }

    public function test_universal_report_engine_orchestrates_foundation_flow(): void
    {
        $engine = app(UniversalReportEngine::class);

        $result = $engine->generate(new ReportRequest('executive-summary', 'json', 'id'));

        $this->assertSame('executive-summary', $result['definition']['id']);
        $this->assertSame('executive-summary', $result['template']['key']);
        $this->assertSame('json', $result['export']['format']);
        $this->assertFalse($result['export']['production_file_export']);
        $this->assertTrue($result['meta']['read_only']);
        $this->assertTrue($result['meta']['generate_never_store']);
    }
}
