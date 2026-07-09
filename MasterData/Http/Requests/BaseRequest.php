<?php

namespace MasterData\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(array_filter($this->all(), function ($value) {
            return $value !== null && $value !== '';
        }));
    }
}