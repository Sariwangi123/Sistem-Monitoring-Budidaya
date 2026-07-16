<?php

namespace Modules\Administration\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class AdministrationOverviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->resource;
    }

    public function with(Request $request): array
    {
        return ['success' => true, 'message' => 'System Administration foundation overview retrieved.', 'meta' => ['module' => 'system-administration', 'part' => 'foundation', 'business_transaction_management_enabled' => false, 'configuration_registry_mode' => 'metadata_foundation']];
    }
}
