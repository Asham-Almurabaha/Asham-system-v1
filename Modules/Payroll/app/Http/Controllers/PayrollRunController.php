<?php

namespace Modules\Payroll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Payroll\Models\PayrollRun;
use Modules\Org\Models\Company;

class PayrollRunController extends Controller
{
    public function index()
    {
        $runs = PayrollRun::orderByDesc('id')->get();
        return view('payroll::runs.index', compact('runs'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('payroll::runs.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => ['required','exists:companies,id'],
            'month' => ['required','date_format:Y-m'],
        ]);
        $data['status'] = 'draft';
        try {
            $run = PayrollRun::create($data);
            session()->flash('success', __('app.Saved'));
            return redirect()->route('hr.payroll-runs.show', $run);
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
            return back();
        }
    }

    public function show(PayrollRun $payroll_run)
    {
        $payroll_run->load('items.employee');
        return view('payroll::runs.show', ['run' => $payroll_run]);
    }

    public function post(PayrollRun $run)
    {
        if ($run->status === 'posted') {
            return back()->with('error', __('app.Validation errors'));
        }
        $run->update(['status'=>'posted','posted_at'=>now()]);
        return back()->with('success', __('app.Updated'));
    }
}
