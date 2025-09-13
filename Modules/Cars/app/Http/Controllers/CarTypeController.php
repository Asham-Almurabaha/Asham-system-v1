<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarType;

class CarTypeController extends Controller
{
    public function index()
    {
        $items = CarType::orderBy('id')->paginate(15);
        return view('cars::car-types.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:100', 'unique:car_types,name_en'],
            'name_ar' => ['required', 'string', 'max:100', 'unique:car_types,name_ar'],
        ]);
        CarType::create($data);

        return redirect()->route('car-types.index')
            ->with('success', __('cars::types.Created successfully'));
    }

    public function edit(CarType $carType)
    {
        return view('cars::car-types.edit', ['item' => $carType]);
    }

    public function update(Request $request, CarType $carType)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:100', 'unique:car_types,name_en,' . $carType->id],
            'name_ar' => ['required', 'string', 'max:100', 'unique:car_types,name_ar,' . $carType->id],
        ]);
        $carType->update($data);

        return redirect()->route('car-types.index')
            ->with('success', __('cars::types.Updated successfully'));
    }

    public function destroy(CarType $carType)
    {
        $carType->delete();

        return redirect()->route('car-types.index')
            ->with('success', __('cars::types.Deleted successfully'));
    }
}
