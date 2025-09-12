<?php

namespace Modules\Cars\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
{
    public function rules(): array
    {
        $currentYear = now()->year + 1;
        $id = $this->route('car')?->id;
        return [
            'plate_number' => ['required', 'regex:/^[أ-ي]{1,2}\s?\d{4}$/', Rule::unique('cars', 'plate_number')->ignore($id)],
            'vin' => ['nullable', Rule::unique('cars', 'vin')->ignore($id)],
            'year' => ['nullable','integer','between:1990,'.$currentYear],
            'status' => ['required'],
            'purchase_date' => ['nullable','date'],
            'cost' => ['nullable','numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
