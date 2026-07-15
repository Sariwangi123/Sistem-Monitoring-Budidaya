<?php

namespace Dashboard\Http\Resources;

use Dashboard\Widgets\Support\WidgetContainer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DashboardWorkspaceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'workspace' => [
                'key' => $this->definition->key,
                'title' => $this->definition->title,
                'layout' => 'Grid',
            ],
            'widgets' => array_map(
                fn (WidgetContainer $container): array => [
                    'key' => $container->definition->key,
                    'title' => $container->definition->title,
                    'category' => $container->definition->category,
                    'size' => $container->definition->size,
                    'refresh_seconds' => $container->definition->refreshSeconds,
                    'component' => $container->definition->component,
                    'required_permission' => $container->definition->requiredPermission,
                    'data_source' => $container->definition->dataSource,
                    'allowed_roles' => $container->definition->allowedRoles,
                    'status' => $container->status,
                    'data' => $container->data,
                    'error' => $container->error,
                    'meta' => $container->meta,
                ],
                $this->containers
            ),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Success',
        ];
    }
}
