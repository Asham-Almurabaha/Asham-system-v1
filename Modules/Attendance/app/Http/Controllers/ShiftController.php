<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Attendance\Models\Shift;

class ShiftController extends Controller
{
    public function index()
    {
        $items = Shift::orderBy('id')->get();
        return view('attendance::shifts.index', compact('items'));
    }

    public function create()
    {
        return view('attendance::shifts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'break_minutes' => ['required','integer'],
        ]);
        try {
            Shift::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.shifts.index');
    }

    public function edit(Shift $shift)
    {
        return view('attendance::shifts.edit', ['item'=>$shift]);
    }

    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'start_time' => ['required'],
            'end_time' => ['required'],
            'break_minutes' => ['required','integer'],
        ]);
        try {
            $shift->update($data);
            session()->flash('success', __('app.Updated'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.shifts.index');
    }

    public function destroy(Shift $shift)
    {
        try {
            $shift->delete();
            session()->flash('success', __('app.Deleted'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }
}
