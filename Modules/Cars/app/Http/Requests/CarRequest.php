<?php

namespace Modules\Cars\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CarRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('car')?->id;
        return [
            'plate_number' => ['required', 'regex:/^[أ-ي]{1,2}\s?\d{4}$/', Rule::unique('cars', 'plate_number')->ignore($id)],
            'vin' => ['nullable', Rule::unique('cars', 'vin')->ignore($id)],
            'car_year_id' => ['nullable','exists:car_years,id'],
            'car_type_id' => ['nullable','exists:car_types,id'],
            'car_brand_id' => ['nullable','exists:car_brands,id'],
            'car_model_id' => ['nullable','exists:car_models,id'],
            'car_color_id' => ['nullable','exists:car_colors,id'],
            'car_status_id' => ['required','exists:car_statuses,id'],
            'branch_id' => ['nullable','exists:branches,id'],
            'purchase_date' => ['nullable','date'],
            'cost' => ['nullable','numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
