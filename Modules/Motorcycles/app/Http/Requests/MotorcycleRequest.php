<?php

namespace Modules\Motorcycles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MotorcycleRequest extends FormRequest
{
    public function rules(): array
    {
        $currentYear = now()->year + 1;
        $id = $this->route('motorcycle')?->id;
        return [
            'plate_number' => ['required', 'regex:/^[أ-ي]{1,2}\s?\d{4}$/', Rule::unique('motorcycles', 'plate_number')->ignore($id)],
            'chassis_number' => ['nullable', Rule::unique('motorcycles', 'chassis_number')->ignore($id)],
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
