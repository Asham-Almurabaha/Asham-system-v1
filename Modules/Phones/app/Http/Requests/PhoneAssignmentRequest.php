<?php

namespace Modules\Phones\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneAssignmentRequest extends FormRequest
{
    public function rules(): array
    {
        if ($this->routeIs('phones.assignments.return')) {
            $rules = [
                'returned_at' => ['required', 'date'],
                'condition_on_return' => ['required'],
            ];

            $assignment = $this->route('assignment');
            if ($assignment && $assignment->assigned_at) {
                $rules['returned_at'][] = 'after_or_equal:' . $assignment->assigned_at->format('Y-m-d H:i:s');
            }

            return $rules;
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
