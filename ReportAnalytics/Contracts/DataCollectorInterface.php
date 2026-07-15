<?php

namespace ReportAnalytics\Contracts;

use ReportAnalytics\Support\ReportDefinition;

interface DataCollectorInterface
{
    /** @return array<string, mixed> */
    public function collect(ReportDefinition $definition, array $parameters = []): array;
}
