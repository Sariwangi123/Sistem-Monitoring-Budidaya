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
        'administration' => 'Administration',
    ];

    /** @var array<string, string> */
    private const ROLE_WORKSPACES = [
        'super-admin' => 'administration',
        'farm-owner' => 'executive',
        'director' => 'executive',
        'farm-manager' => 'production',
        'warehouse-staff' => 'inventory',
        'finance-staff' => 'finance',
        'technician' => 'production',
    ];

    public function resolve(array $roleSlugs, ?string $requestedWorkspace = null): WorkspaceDefinition
    {
        $allowedWorkspaces = $this->workspacesForRoles($roleSlugs);

        if ($requestedWorkspace && in_array($requestedWorkspace, $allowedWorkspaces, true)) {
            return $this->definition($requestedWorkspace);
        }

        return $this->definition($allowedWorkspaces[0] ?? 'executive');
    }

    /** @return array<int, string> */
    private function workspacesForRoles(array $roleSlugs): array
    {
        $workspaces = array_values(array_unique(array_filter(array_map(
            fn (string $roleSlug): ?string => self::ROLE_WORKSPACES[$roleSlug] ?? null,
            $roleSlugs
        ))));

        return $workspaces ?: ['executive'];
    }

    private function definition(string $workspace): WorkspaceDefinition
    {
        return new WorkspaceDefinition($workspace, self::WORKSPACE_TITLES[$workspace]);
    }
}
