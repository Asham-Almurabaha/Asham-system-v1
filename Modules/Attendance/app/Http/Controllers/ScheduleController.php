<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Attendance\Models\Schedule;
use Modules\Attendance\Models\Shift;
use Modules\Employees\Models\Employee;

class ScheduleController extends Controller
{
    public function index(Employee $employee)
    {
        $schedules = $employee->schedules()->with('shift')->orderBy('date')->get();
        $shifts = Shift::all();
        return view('attendance::schedules.index', compact('employee','schedules','shifts'));
    }

    public function store(Employee $employee, Request $request)
    {
        $data = $request->validate([
            'date' => ['required','date','unique:schedules,date,NULL,id,employee_id,'.$employee->id],
            'shift_id' => ['required','exists:shifts,id'],
        ]);
        $data['employee_id'] = $employee->id;
        try {
            Schedule::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.employees.schedules.index', $employee);
    }

    public function update(Employee $employee, Schedule $schedule, Request $request)
    {
        $data = $request->validate([
            'date' => ['required','date','unique:schedules,date,'.$schedule->id.',id,employee_id,'.$employee->id],
            'shift_id' => ['required','exists:shifts,id'],
        ]);
        try {
            $schedule->update($data);
            session()->flash('success', __('app.Updated'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.employees.schedules.index', $employee);
    }
}
