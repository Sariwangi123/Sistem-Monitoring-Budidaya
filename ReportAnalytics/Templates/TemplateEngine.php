<?php

namespace ReportAnalytics\Templates;

use ReportAnalytics\Exceptions\InvalidReportTemplateException;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportTemplate;

final class TemplateEngine
{
    public function __construct(private TemplateResolver $resolver)
    {
    }

    public function resolve(ReportDefinition $definition): ReportTemplate
    {
        $template = $this->resolver->resolve($definition->template);

        if ($template->key !== $definition->template || $template->sections === []) {
            throw InvalidReportTemplateException::forTemplate($definition->template);
        }

        return $template;
    }
}
