<?php

namespace ReportAnalytics\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ReportAnalyticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource['data'] ?? [];
    }

    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this->resource['message'] ?? 'Success',
            'meta' => $this->resource['meta'] ?? [],
        ];
    }
}
