<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\CarAssignment;
use Modules\Cars\Entities\CarStatus;
use Modules\Cars\Http\Requests\CarAssignmentRequest;

class CarAssignmentController extends Controller
{
    public function store(CarAssignmentRequest $request, Car $car): RedirectResponse
    {
        if ($car->currentAssignment) {
            return back()->withErrors(__('cars::assignments.Car already assigned'));
        }
        $assignment = $car->assignments()->create($request->validated());
        $car->status = CarStatus::ASSIGNED;
        $car->save();
        return redirect()->route('cars.show', $car)->with('success', __('cars::assignments.Assigned'));
    }

    public function return(CarAssignmentRequest $request, Car $car, CarAssignment $assignment): RedirectResponse
    {
        $assignment->update($request->validated());
        $car->status = $request->input('condition_on_return') === 'needs_maintenance' ? CarStatus::MAINTENANCE : CarStatus::AVAILABLE;
        $car->save();
        return redirect()->route('cars.show', $car)->with('success', __('cars::assignments.Returned'));
    }

    public function history(Car $car): View
    {
        $history = $car->assignments()->with('employee')->latest()->get();
        return view('cars::assignments._list', compact('car','history'));
    }
}
