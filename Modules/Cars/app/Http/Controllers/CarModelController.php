<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarModel;
use Modules\Cars\Entities\Lookups\CarBrand;

class CarModelController extends Controller
{
    public function index()
    {
        return response()->json(CarModel::with('type','brand')->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'car_brand_id' => 'required|exists:car_brands,id',
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]);

        if (CarBrand::where('id', $data['car_brand_id'])->where('car_type_id', $data['car_type_id'])->doesntExist()) {
            return response()->json(['message' => 'brand does not belong to type'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $model = CarModel::create($data);

        return response()->json($model, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarModel $carModel)
    {
        $data = $request->validate([
            'car_type_id' => 'required|exists:car_types,id',
            'car_brand_id' => 'required|exists:car_brands,id',
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]);

        if (CarBrand::where('id', $data['car_brand_id'])->where('car_type_id', $data['car_type_id'])->doesntExist()) {
            return response()->json(['message' => 'brand does not belong to type'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $carModel->update($data);

        return response()->json($carModel);
    }

    public function destroy(CarModel $carModel)
    {
        $carModel->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
