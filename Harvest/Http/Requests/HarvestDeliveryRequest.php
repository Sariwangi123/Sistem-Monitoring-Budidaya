<?php

namespace Harvest\Http\Requests;

use Illuminate\Validation\Rule;
use MasterData\Http\Requests\BaseRequest;

final class HarvestDeliveryRequest extends BaseRequest
{
    public function rules(): array
    {
        $uuid = $this->route('delivery') ?? $this->route('harvest_delivery') ?? $this->route('id');

        return [
            'harvest_id' => ['required', 'integer', 'exists:harvests,id'],
            'harvest_packing_id' => ['nullable', 'integer', 'exists:harvest_packings,id'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'driver_user_id' => ['nullable', 'integer', 'exists:users,id'],
            'delivery_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvest_deliveries', 'delivery_code')->ignore($uuid, 'uuid'),
            ],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('harvest_deliveries', 'document_number')->ignore($uuid, 'uuid'),
            ],
            'delivery_date' => ['required', 'date'],
            'vehicle_number' => ['nullable', 'string', 'max:255'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'package_quantity' => ['sometimes', 'integer', 'min:0'],
            'delivered_weight' => ['sometimes', 'numeric', 'min:0'],
            'delivery_status' => ['required', 'string', Rule::in(['Scheduled', 'In Transit', 'Delivered', 'Cancelled'])],
            'notes' => ['nullable', 'string'],
        ];
    }
}
