<?php

namespace Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payroll\Models\PayrollRun;
use Modules\Payroll\Models\PayrollItem;

class PayrollItemController extends Controller
{
    public function upsert(PayrollRun $run, Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'basic' => ['required','numeric'],
            'allowances' => ['nullable','array'],
            'deductions' => ['nullable','array'],
            'overtime_amount' => ['nullable','numeric'],
            'absence_amount' => ['nullable','numeric'],
            'net' => ['required','numeric'],
        ]);
        $data['payroll_run_id'] = $run->id;
        try {
            PayrollItem::updateOrCreate(
                ['payroll_run_id'=>$run->id,'employee_id'=>$data['employee_id']],
                $data
            );
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }
}
