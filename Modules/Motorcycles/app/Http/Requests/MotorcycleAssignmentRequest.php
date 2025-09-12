<?php

namespace Modules\Motorcycles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MotorcycleAssignmentRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->routeIs('motorcycles.assignments.return')) {
            return [
                'returned_at' => ['required','date','after_or_equal:assigned_at'],
                'condition_on_return' => ['required'],
            ];
        }
        return [
            'employee_id' => ['required','integer'],
            'assigned_at' => ['required','date'],
            'condition_on_assign' => ['required'],
            'handover_form_number' => ['nullable','string','max:50'],
            'assigned_by' => ['nullable','integer'],
            'notes' => ['nullable','string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
