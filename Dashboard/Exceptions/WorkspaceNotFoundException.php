<?php

namespace Dashboard\Exceptions;

use RuntimeException;

final class WorkspaceNotFoundException extends RuntimeException
{
    public static function forWorkspace(string $workspace): self
    {
        return new self("Dashboard workspace '{$workspace}' was not found.");
    }
}
