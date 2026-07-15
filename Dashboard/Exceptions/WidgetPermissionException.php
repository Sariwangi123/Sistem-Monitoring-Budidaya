<?php

namespace Dashboard\Exceptions;

use RuntimeException;

final class WidgetPermissionException extends RuntimeException
{
    public static function forWidget(string $widgetKey): self
    {
        return new self("Dashboard widget '{$widgetKey}' is not available for the current role.");
    }
}
