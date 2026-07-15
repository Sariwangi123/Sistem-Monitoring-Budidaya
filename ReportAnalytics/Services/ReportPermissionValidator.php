<?php

namespace ReportAnalytics\Services;

use ReportAnalytics\Exceptions\ReportPermissionException;
use ReportAnalytics\Support\ReportDefinition;

final class ReportPermissionValidator
{
    /** @param array<int, string> $roleSlugs */
    public function validate(ReportDefinition $definition, array $roleSlugs): void
    {
        if ($roleSlugs === []) {
            return;
        }

        if (in_array('super-admin', $roleSlugs, true) || array_intersect($roleSlugs, $definition->allowedRoles) !== []) {
            return;
        }

        throw ReportPermissionException::forReport($definition->id);
    }
}
