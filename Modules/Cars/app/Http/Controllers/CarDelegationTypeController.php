<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarDelegationType;

class CarDelegationTypeController extends Controller
{
    public function index()
    {
        $items = CarDelegationType::orderBy('id')->paginate(15);
        return view('cars::car-delegation-types.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-delegation-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_delegation_types,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_delegation_types,name_ar'],
        ]);
        CarDelegationType::create($data);

        return redirect()->route('car-delegation-types.index')
            ->with('success', __('cars::delegation-types.Created successfully'));
    }

    public function edit(CarDelegationType $carDelegationType)
    {
        return view('cars::car-delegation-types.edit', ['item' => $carDelegationType]);
    }

    public function update(Request $request, CarDelegationType $carDelegationType)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_delegation_types,name_en,' . $carDelegationType->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_delegation_types,name_ar,' . $carDelegationType->id],
        ]);
        $carDelegationType->update($data);

        return redirect()->route('car-delegation-types.index')
            ->with('success', __('cars::delegation-types.Updated successfully'));
    }

    public function destroy(CarDelegationType $carDelegationType)
    {
        $carDelegationType->delete();

        return redirect()->route('car-delegation-types.index')
            ->with('success', __('cars::delegation-types.Deleted successfully'));
    }
}
