<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\ViolationPaymentStatus;

class ViolationPaymentStatusController extends Controller
{
    public function index()
    {
        $items = ViolationPaymentStatus::orderBy('id')->paginate(15);
        return view('cars::violation-payment-statuses.index', compact('items'));
    }

    public function create()
    {
        return view('cars::violation-payment-statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:violation_payment_statuses,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:violation_payment_statuses,name_ar'],
        ]);
        ViolationPaymentStatus::create($data);

        return redirect()->route('violation-payment-statuses.index')
            ->with('success', __('cars::violation-payment-statuses.Created successfully'));
    }

    public function edit(ViolationPaymentStatus $violationPaymentStatus)
    {
        return view('cars::violation-payment-statuses.edit', ['item' => $violationPaymentStatus]);
    }

    public function update(Request $request, ViolationPaymentStatus $violationPaymentStatus)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:violation_payment_statuses,name_en,' . $violationPaymentStatus->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:violation_payment_statuses,name_ar,' . $violationPaymentStatus->id],
        ]);
        $violationPaymentStatus->update($data);

        return redirect()->route('violation-payment-statuses.index')
            ->with('success', __('cars::violation-payment-statuses.Updated successfully'));
    }

    public function destroy(ViolationPaymentStatus $violationPaymentStatus)
    {
        $violationPaymentStatus->delete();

        return redirect()->route('violation-payment-statuses.index')
            ->with('success', __('cars::violation-payment-statuses.Deleted successfully'));
    }
}
