<?php

namespace Modules\Phones\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PhoneRequest extends FormRequest
{
    public function rules(): array
    {
        $id = $this->route('phone')?->id;
        return [
            'imei' => ['required','digits:15', Rule::unique('phones', 'imei')->ignore($id)],
            'serial_number' => ['nullable', Rule::unique('phones','serial_number')->ignore($id)],
            'brand' => ['nullable','string'],
            'model' => ['nullable','string'],
            'color' => ['nullable','string'],
            'line_number' => ['nullable','regex:/^\+9665\d{8}$/'],
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
