<?php

namespace ReportAnalytics\Templates;

use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportTemplate;

final class TemplateEngine
{
    public function __construct(private TemplateResolver $resolver)
    {
    }

    public function resolve(ReportDefinition $definition): ReportTemplate
    {
        return $this->resolver->resolve($definition->template);
    }
}
