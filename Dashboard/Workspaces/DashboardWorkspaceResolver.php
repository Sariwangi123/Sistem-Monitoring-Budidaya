<?php

namespace Dashboard\Workspaces;

final class DashboardWorkspaceResolver
{
    /** @var array<string, string> */
    private const WORKSPACE_TITLES = [
        'executive' => 'Executive',
        'production' => 'Production',
        'inventory' => 'Inventory',
        'harvest' => 'Harvest',
        'finance' => 'Finance',
        'system' => 'System',
        'administration' => 'System',
    ];

    /** @var array<string, array<int, string>> */
    private const ROLE_WORKSPACES = [
        'super-admin' => ['executive', 'production', 'inventory', 'harvest', 'finance', 'system'],
        'farm-owner' => ['executive', 'production', 'harvest', 'finance'],
        'director' => ['executive', 'production', 'harvest', 'finance'],
        'farm-manager' => ['production', 'harvest', 'inventory'],
        'warehouse-staff' => ['inventory'],
        'finance-staff' => ['finance'],
        'technician' => ['production', 'harvest'],
        'viewer' => ['executive'],
    ];

    public function resolve(array $roleSlugs, ?string $requestedWorkspace = null): WorkspaceDefinition
    {
        $allowedWorkspaces = $this->workspacesForRoles($roleSlugs);

        $requestedWorkspace = $requestedWorkspace ? $this->normalizeWorkspace($requestedWorkspace) : null;

        if ($requestedWorkspace && in_array($requestedWorkspace, $allowedWorkspaces, true)) {
            return $this->definition($requestedWorkspace);
        }

        return $this->definition($allowedWorkspaces[0] ?? 'executive');
    }

    /** @return array<int, string> */
    public function workspacesForRoles(array $roleSlugs): array
    {
        $workspaces = [];

        foreach ($roleSlugs as $roleSlug) {
            $workspaces = [...$workspaces, ...(self::ROLE_WORKSPACES[$roleSlug] ?? [])];
        }

        return array_values(array_unique($workspaces ?: ['executive']));
    }

    private function definition(string $workspace): WorkspaceDefinition
    {
        return new WorkspaceDefinition($workspace, self::WORKSPACE_TITLES[$workspace]);
    }

    private function normalizeWorkspace(string $workspace): string
    {
        return $workspace === 'administration' ? 'system' : $workspace;
    }
}
