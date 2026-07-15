<?php

namespace Dashboard\Workspaces;

final readonly class WorkspaceDefinition
{
    public function __construct(
        public string $key,
        public string $title
    ) {
    }
}
