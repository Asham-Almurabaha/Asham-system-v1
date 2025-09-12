<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarBrand;

class CarBrandController extends Controller
{
    public function index()
    {
        return response()->json(CarBrand::with('type','models')->get());
    }

    public function store(Request $request)
    {
        $brand = CarBrand::create($request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]));

        return response()->json($brand, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarBrand $carBrand)
    {
        $carBrand->update($request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]));

        return response()->json($carBrand);
    }

    public function destroy(CarBrand $carBrand)
    {
        $carBrand->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
