<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\{CarBrand, CarType};

class CarBrandController extends Controller
{
    public function index()
    {
        $items = CarBrand::with('type')->orderBy('id')->paginate(15);
        return view('cars::car-brands.index', compact('items'));
    }

    public function create()
    {
        $types = CarType::all();
        return view('cars::car-brands.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_type_id' => ['required', 'exists:car_types,id'],
            'name_en' => ['required', 'string', 'max:100'],
            'name_ar' => ['required', 'string', 'max:100'],
        ]);
        CarBrand::create($data);

        return redirect()->route('car-brands.index')
            ->with('success', __('cars::brands.Created successfully'));
    }

    public function edit(CarBrand $carBrand)
    {
        $types = CarType::all();
        return view('cars::car-brands.edit', ['item' => $carBrand, 'types' => $types]);
    }

    public function update(Request $request, CarBrand $carBrand)
    {
        $data = $request->validate([
            'car_type_id' => ['required', 'exists:car_types,id'],
            'name_en' => ['required', 'string', 'max:100'],
            'name_ar' => ['required', 'string', 'max:100'],
        ]);
        $carBrand->update($data);

        return redirect()->route('car-brands.index')
            ->with('success', __('cars::brands.Updated successfully'));
    }

    public function destroy(CarBrand $carBrand)
    {
        $carBrand->delete();

        return redirect()->route('car-brands.index')
            ->with('success', __('cars::brands.Deleted successfully'));
    }
}
