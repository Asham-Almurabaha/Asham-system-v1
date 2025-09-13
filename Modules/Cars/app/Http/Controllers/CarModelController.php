<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\{CarModel, CarBrand, CarType};

class CarModelController extends Controller
{
    public function index()
    {
        $items = CarModel::with('brand.type')->orderBy('id')->paginate(15);
        return view('cars::car-models.index', compact('items'));
    }

    public function create()
    {
        $types = CarType::all();
        $brands = CarBrand::all();
        return view('cars::car-models.create', compact('types', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_type_id' => ['required', 'exists:car_types,id'],
            'car_brand_id' => ['required', 'exists:car_brands,id'],
            'name_en' => ['required', 'string', 'max:100'],
            'name_ar' => ['required', 'string', 'max:100'],
        ]);

        if (CarBrand::where('id', $data['car_brand_id'])->where('car_type_id', $data['car_type_id'])->doesntExist()) {
            return back()->withErrors(['car_brand_id' => __('cars::models.Brand mismatch')])->withInput();
        }

        CarModel::create($data);

        return redirect()->route('car-models.index')
            ->with('success', __('cars::models.Created successfully'));
    }

    public function edit(CarModel $carModel)
    {
        $types = CarType::all();
        $brands = CarBrand::all();
        return view('cars::car-models.edit', ['item' => $carModel, 'types' => $types, 'brands' => $brands]);
    }

    public function update(Request $request, CarModel $carModel)
    {
        $data = $request->validate([
            'car_type_id' => ['required', 'exists:car_types,id'],
            'car_brand_id' => ['required', 'exists:car_brands,id'],
            'name_en' => ['required', 'string', 'max:100'],
            'name_ar' => ['required', 'string', 'max:100'],
        ]);

        if (CarBrand::where('id', $data['car_brand_id'])->where('car_type_id', $data['car_type_id'])->doesntExist()) {
            return back()->withErrors(['car_brand_id' => __('cars::models.Brand mismatch')])->withInput();
        }

        $carModel->update($data);

        return redirect()->route('car-models.index')
            ->with('success', __('cars::models.Updated successfully'));
    }

    public function destroy(CarModel $carModel)
    {
        $carModel->delete();

        return redirect()->route('car-models.index')
            ->with('success', __('cars::models.Deleted successfully'));
    }
}
