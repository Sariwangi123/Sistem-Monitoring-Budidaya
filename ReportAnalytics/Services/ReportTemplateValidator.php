<?php

namespace ReportAnalytics\Services;

use ReportAnalytics\Exceptions\InvalidReportTemplateException;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportTemplate;

final class ReportTemplateValidator
{
    public function validate(ReportDefinition $definition, ReportTemplate $template): void
    {
        if ($definition->template !== $template->key || $template->sections === []) {
            throw InvalidReportTemplateException::forTemplate($template->key);
        }
    }
}
