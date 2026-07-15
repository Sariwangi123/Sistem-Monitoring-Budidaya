<?php

namespace Dashboard\Exceptions;

use RuntimeException;

final class WidgetNotFoundException extends RuntimeException
{
    public static function forKey(string $widgetKey): self
    {
        return new self("Dashboard widget '{$widgetKey}' was not found.");
    }
}
