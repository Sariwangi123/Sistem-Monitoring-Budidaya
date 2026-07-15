<?php

namespace ReportAnalytics\Templates;

use ReportAnalytics\Support\ReportLayout;
use ReportAnalytics\Support\ReportTemplate;

final class TemplateResolver
{
    public function resolve(string $templateKey): ReportTemplate
    {
        return new ReportTemplate(
            key: $templateKey,
            title: str($templateKey)->headline()->toString(),
            layout: new ReportLayout(
                cover: 'standard-cover',
                header: 'standard-header',
                body: 'sectioned-body',
                summary: 'standard-summary',
                footer: 'standard-footer'
            ),
            sections: $this->sectionsFor($templateKey),
            format: [
                'orientation' => 'portrait',
                'paper' => 'A4',
                'theme' => 'utifarm',
            ]
        );
    }

    /** @return array<int, string> */
    private function sectionsFor(string $templateKey): array
    {
        return match ($templateKey) {
            'executive-summary' => ['cover', 'executive_summary', 'kpi_summary', 'closing'],
            'financial-performance' => ['cover', 'financial_summary', 'profitability', 'closing'],
            'audit-trail' => ['cover', 'audit_summary', 'activity_history', 'closing'],
            default => ['cover', 'summary', 'details', 'closing'],
        };
    }
}
