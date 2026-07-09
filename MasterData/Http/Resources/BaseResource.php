<?php

namespace MasterData\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Success',
        ];
    }

    protected function getAuditFields(Request $request): array
    {
        return [
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}