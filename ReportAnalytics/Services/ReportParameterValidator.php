<?php

namespace ReportAnalytics\Services;

use InvalidArgumentException;
use ReportAnalytics\Support\ReportDefinition;
use ReportAnalytics\Support\ReportRequest;

final class ReportParameterValidator
{
    private const SUPPORTED_LOCALES = ['id', 'en'];

    public function validate(ReportDefinition $definition, ReportRequest $request): void
    {
        if (! in_array($request->format, $definition->supportedExportFormats, true)) {
            throw new InvalidArgumentException('Export format is not supported by this report.');
        }

        if (! in_array($request->locale, self::SUPPORTED_LOCALES, true)) {
            throw new InvalidArgumentException('Report locale is not supported.');
        }
    }
}
