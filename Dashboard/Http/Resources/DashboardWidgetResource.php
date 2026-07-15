<?php

namespace Dashboard\Http\Resources;

use Dashboard\Widgets\Support\WidgetContainer;
use Dashboard\Widgets\Support\WidgetDefinition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class DashboardWidgetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource instanceof WidgetContainer) {
            return [
                ...$this->definition($this->resource->definition),
                'status' => $this->resource->status,
                'data' => $this->resource->data,
                'error' => $this->resource->error,
            ];
        }

        return $this->definition($this->resource);
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Success',
        ];
    }

    private function definition(WidgetDefinition $definition): array
    {
        return [
            'key' => $definition->key,
            'workspace' => $definition->workspace,
            'title' => $definition->title,
            'category' => $definition->category,
            'size' => $definition->size,
            'refresh_seconds' => $definition->refreshSeconds,
        ];
    }
}
