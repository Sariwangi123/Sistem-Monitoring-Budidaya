<?php

namespace Dashboard\Workspaces;

final readonly class DashboardWorkspace
{
    public function __construct(
        public WorkspaceDefinition $definition,
        public array $containers
    ) {
    }
}
