<?php

namespace Modules\Contracts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Contracts\Models\Contract;
use Modules\Employees\Models\Employee;

class ContractController extends Controller
{
    public function index(Employee $employee)
    {
        $contracts = $employee->contracts()->latest()->get();
        return view('contracts::index', compact('employee','contracts'));
    }

    public function create(Employee $employee)
    {
        return view('contracts::create', compact('employee'));
    }

    public function store(Employee $employee, Request $request)
    {
        $data = $request->validate([
            'start_at' => ['required','date'],
            'end_at' => ['nullable','date','after_or_equal:start_at'],
            'probation_end_at' => ['nullable','date'],
            'type' => ['nullable','in:full_time,part_time,contractor'],
            'housing_allowance' => ['nullable','numeric'],
            'transport_allowance' => ['nullable','numeric'],
            'other_allowances' => ['nullable','json'],
            'status' => ['nullable','in:active,inactive,ended'],
            'attachment' => ['nullable','file','max:8192'],
        ]);
        if ($employee->contracts()->where('status','active')->exists() && ($data['status'] ?? 'active') === 'active') {
            return back()->withErrors(['status' => __('contracts::contracts.active_exists')])->withInput();
        }
        $data['employee_id'] = $employee->id;
        $data['status'] = $data['status'] ?? 'active';
        if (!empty($data['other_allowances'])) {
            $data['other_allowances'] = json_decode($data['other_allowances'], true);
        }
        try {
            if ($request->hasFile('attachment')) {
                $data['attachment_path'] = $request->file('attachment')->store('contracts');
            }
            Contract::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.employees.contracts.index', $employee);
    }

    public function destroy(Contract $contract)
    {
        try {
            $contract->delete();
            session()->flash('success', __('app.Deleted'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }
}
