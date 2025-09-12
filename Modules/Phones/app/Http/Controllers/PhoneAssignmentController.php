<?php

namespace Modules\Phones\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Phones\Entities\Phone;
use Modules\Phones\Entities\PhoneAssignment;
use Modules\Phones\Entities\PhoneStatus;
use Modules\Phones\Http\Requests\PhoneAssignmentRequest;

class PhoneAssignmentController extends Controller
{
    public function store(PhoneAssignmentRequest $request, Phone $phone): RedirectResponse
    {
        if ($phone->currentAssignment) {
            return back()->withErrors(__('phones::assignments.Phone already assigned'));
        }
        $phone->assignments()->create($request->validated());
        $phone->status = PhoneStatus::ASSIGNED;
        $phone->save();
        return redirect()->route('phones.show', $phone)->with('success', __('phones::assignments.Assigned'));
    }

    public function return(PhoneAssignmentRequest $request, Phone $phone, PhoneAssignment $assignment): RedirectResponse
    {
        $assignment->update($request->validated());
        $phone->status = $request->input('condition_on_return') === 'damaged' ? PhoneStatus::MAINTENANCE : PhoneStatus::AVAILABLE;
        $phone->save();
        return redirect()->route('phones.show', $phone)->with('success', __('phones::assignments.Returned'));
    }

    public function history(Phone $phone): View
    {
        $history = $phone->assignments()->with('employee')->latest()->get();
        return view('phones::assignments._list', compact('phone','history'));
    }
}
