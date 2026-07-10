<?php

namespace Warehouse\Http\Resources;

use Illuminate\Http\Request;
use MasterData\Http\Resources\BaseResource;

final class StockOpnameResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'warehouse_id' => $this->warehouse_id,
            'user_id' => $this->user_id,
            'opname_number' => $this->opname_number,
            'opname_date' => $this->opname_date?->format('Y-m-d'),
            'status' => $this->status,
            'notes' => $this->notes,
            ...$this->getAuditFields($request),
        ];
    }
}
