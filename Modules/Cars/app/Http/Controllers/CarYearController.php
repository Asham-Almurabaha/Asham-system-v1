<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarYear;

class CarYearController extends Controller
{
    public function index()
    {
        $items = CarYear::orderByDesc('year')->paginate(15);
        return view('cars::car-years.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-years.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'unique:car_years,year'],
        ]);
        CarYear::create($data);

        return redirect()->route('car-years.index')
            ->with('success', __('cars::years.Created successfully'));
    }

    public function edit(CarYear $carYear)
    {
        return view('cars::car-years.edit', ['item' => $carYear]);
    }

    public function update(Request $request, CarYear $carYear)
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'unique:car_years,year,' . $carYear->id],
        ]);
        $carYear->update($data);

        return redirect()->route('car-years.index')
            ->with('success', __('cars::years.Updated successfully'));
    }

    public function destroy(CarYear $carYear)
    {
        $carYear->delete();

        return redirect()->route('car-years.index')
            ->with('success', __('cars::years.Deleted successfully'));
    }
}
