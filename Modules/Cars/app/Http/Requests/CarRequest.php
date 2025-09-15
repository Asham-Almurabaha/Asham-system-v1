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
            'sequence_number' => ['nullable', Rule::unique('cars', 'sequence_number')->ignore($id)],
            'plate_letters' => ['required', 'regex:/^[أ-ي]{3}$/u'],
            'plate_numbers' => [
                'required',
                'digits:4',
                Rule::unique('cars')->where(fn($q) => $q->where('plate_letters', $this->plate_letters))->ignore($id),
            ],
            'vin' => ['nullable', Rule::unique('cars', 'vin')->ignore($id)],
            'car_year_id' => ['required','exists:car_years,id'],
            'car_type_id' => ['required','exists:car_types,id'],
            'car_brand_id' => ['required','exists:car_brands,id'],
            'car_model_id' => ['required','exists:car_models,id'],
            'car_color_id' => ['nullable','exists:car_colors,id'],
            'car_status_id' => ['required','exists:car_statuses,id'],
            'branch_id' => ['required','exists:branches,id'],
            'purchase_date' => ['nullable','date'],
            'cost' => ['nullable','numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
