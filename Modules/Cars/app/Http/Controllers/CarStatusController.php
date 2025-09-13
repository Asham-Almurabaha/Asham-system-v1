<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarStatus;

class CarStatusController extends Controller
{
    public function index()
    {
        $items = CarStatus::orderBy('id')->paginate(15);
        return view('cars::car-statuses.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-statuses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_statuses,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_statuses,name_ar'],
        ]);
        CarStatus::create($data);

        return redirect()->route('car-statuses.index')
            ->with('success', __('cars::statuses.Created successfully'));
    }

    public function edit(CarStatus $carStatus)
    {
        return view('cars::car-statuses.edit', ['item' => $carStatus]);
    }

    public function update(Request $request, CarStatus $carStatus)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_statuses,name_en,' . $carStatus->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_statuses,name_ar,' . $carStatus->id],
        ]);
        $carStatus->update($data);

        return redirect()->route('car-statuses.index')
            ->with('success', __('cars::statuses.Updated successfully'));
    }

    public function destroy(CarStatus $carStatus)
    {
        $carStatus->delete();

        return redirect()->route('car-statuses.index')
            ->with('success', __('cars::statuses.Deleted successfully'));
    }
}
