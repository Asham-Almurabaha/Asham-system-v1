<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Attendance\Models\OvertimeRequest;
use Modules\Employees\Models\Employee;

class OvertimeRequestController extends Controller
{
    public function index()
    {
        $items = OvertimeRequest::with('employee')->orderByDesc('date')->get();
        return view('attendance::overtime.index', compact('items'));
    }

    public function create()
    {
        $employees = Employee::orderBy('first_name')->get();
        return view('attendance::overtime.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'date' => ['required','date'],
            'minutes' => ['required','integer'],
        ]);
        $data['status'] = 'pending';
        try {
            OvertimeRequest::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }

    public function approve(OvertimeRequest $overtime)
    {
        $overtime->update(['status' => 'approved', 'approver_id' => Auth::id()]);
        return back()->with('success', __('app.Updated'));
    }

    public function reject(OvertimeRequest $overtime)
    {
        $overtime->update(['status' => 'rejected', 'approver_id' => Auth::id()]);
        return back()->with('success', __('app.Updated'));
    }
}
