<?php

namespace Modules\Leaves\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Leaves\Models\Leave;
use Modules\Leaves\Models\LeaveType;
use Modules\Employees\Models\Employee;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('employee','type');
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('leave_type_id')) $query->where('leave_type_id', $request->leave_type_id);
        if ($request->filled('employee_id')) $query->where('employee_id', $request->employee_id);
        $items = $query->orderByDesc('start_at')->paginate(20);
        return view('leaves::index', compact('items'));
    }

    public function create(Employee $employee)
    {
        $types = LeaveType::all();
        return view('leaves::create', compact('employee','types'));
    }

    public function store(Employee $employee, Request $request)
    {
        $data = $request->validate([
            'start_at' => ['required','date'],
            'end_at' => ['required','date','after_or_equal:start_at'],
            'days' => ['required','numeric'],
            'leave_type_id' => ['required','exists:leave_types,id'],
            'reason' => ['nullable','string'],
        ]);
        $data['employee_id'] = $employee->id;
        $data['status'] = 'pending';
        try {
            Leave::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.leaves.index');
    }

    public function approve(Leave $leave)
    {
        $leave->update(['status'=>'approved','approver_id'=>Auth::id()]);
        // TODO: deduct balance
        return back()->with('success', __('app.Updated'));
    }

    public function reject(Leave $leave)
    {
        $leave->update(['status'=>'rejected','approver_id'=>Auth::id()]);
        return back()->with('success', __('app.Updated'));
    }
}
