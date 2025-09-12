<?php

namespace Modules\Motorcycles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Motorcycles\Entities\Motorcycle;
use Modules\Motorcycles\Entities\MotorcycleAssignment;
use Modules\Motorcycles\Entities\MotorcycleStatus;
use Modules\Motorcycles\Http\Requests\MotorcycleAssignmentRequest;

class MotorcycleAssignmentController extends Controller
{
    public function store(MotorcycleAssignmentRequest $request, Motorcycle $motorcycle): RedirectResponse
    {
        if ($motorcycle->currentAssignment) {
            return back()->withErrors(__('motorcycles::assignments.Motorcycle already assigned'));
        }
        $motorcycle->assignments()->create($request->validated());
        $motorcycle->status = MotorcycleStatus::ASSIGNED;
        $motorcycle->save();
        return redirect()->route('motorcycles.show', $motorcycle)->with('success', __('motorcycles::assignments.Assigned'));
    }

    public function return(MotorcycleAssignmentRequest $request, Motorcycle $motorcycle, MotorcycleAssignment $assignment): RedirectResponse
    {
        $assignment->update($request->validated());
        $motorcycle->status = $request->input('condition_on_return') === 'needs_maintenance' ? MotorcycleStatus::MAINTENANCE : MotorcycleStatus::AVAILABLE;
        $motorcycle->save();
        return redirect()->route('motorcycles.show', $motorcycle)->with('success', __('motorcycles::assignments.Returned'));
    }

    public function history(Motorcycle $motorcycle): View
    {
        $history = $motorcycle->assignments()->with('employee')->latest()->get();
        return view('motorcycles::assignments._list', compact('motorcycle','history'));
    }
}
