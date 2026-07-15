<?php

namespace ReportAnalytics\Builders;

use ReportAnalytics\Contracts\DataCollectorInterface;
use ReportAnalytics\Formatters\ReportDataFormatter;
use ReportAnalytics\Support\ReportBuild;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportSection;
use ReportAnalytics\Support\ReportTemplate;

final class ReportBuilder
{
    public function __construct(
        private DataCollectorInterface $collector,
        private ReportDataFormatter $formatter
    ) {
    }

    public function build(ReportDefinition $definition, ReportTemplate $template, string $locale, array $parameters = []): ReportBuild
    {
        $data = $this->collector->collect($definition, $parameters);
        $generatedAt = new \DateTimeImmutable();

        $sections = array_map(
            fn (string $sectionKey): ReportSection => new ReportSection(
                key: $sectionKey,
                title: str($sectionKey)->headline()->toString(),
                data: [
                    'report_id' => $definition->id,
                    'source_module' => $definition->sourceModule,
                    'generated_at' => $this->formatter->date($generatedAt, $locale),
                    'payload' => $data,
                ]
            ),
            $template->sections
        );

        return new ReportBuild($definition, $template, $sections, $locale);
    }
}
