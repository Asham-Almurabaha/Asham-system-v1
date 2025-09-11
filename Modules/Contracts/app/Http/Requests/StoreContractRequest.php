<?php

namespace Modules\Contracts\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Contracts\Models\Contract;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // TODO: policy
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['required','exists:employees,id'],
            'start_at' => ['required','date'],
            'end_at' => ['nullable','date','after_or_equal:start_at'],
            'probation_end_at' => ['nullable','date'],
            'type' => ['required','string'],
            'housing_allowance' => ['nullable','numeric'],
            'transport_allowance' => ['nullable','numeric'],
            'other_allowances' => ['nullable','array'],
            'status' => ['required','string'],
            'attachment_path' => ['nullable','string'],
            'notes' => ['nullable','string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (($this->input('status') ?? 'active') === 'active') {
                $exists = Contract::where('employee_id', $this->input('employee_id'))
                    ->where('status', 'active')
                    ->exists();
                if ($exists) {
                    $validator->errors()->add('status', __('contracts.active_exists'));
                }
            }
        });
    }
}
