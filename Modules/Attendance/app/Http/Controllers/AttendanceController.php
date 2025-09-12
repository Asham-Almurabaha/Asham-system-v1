<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Attendance\Models\Attendance;
use Modules\Employees\Models\Employee;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('employee');
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('check_in_at', $request->date);
        }
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }
        $items = $query->orderByDesc('check_in_at')->paginate(20);
        return view('attendance::attendances.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'check_in_at' => ['required','date'],
            'check_out_at' => ['nullable','date','after_or_equal:check_in_at'],
            'source' => ['required','in:fingerprint,gps,manual'],
            'lat' => ['nullable','numeric'],
            'lng' => ['nullable','numeric'],
        ]);
        try {
            Attendance::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }
}
