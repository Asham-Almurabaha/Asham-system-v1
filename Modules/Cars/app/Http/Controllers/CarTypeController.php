<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarType;

class CarTypeController extends Controller
{
    public function index()
    {
        return response()->json(CarType::with('brands.models')->get());
    }

    public function store(Request $request)
    {
        $type = CarType::create($request->validate([
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]));

        return response()->json($type, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarType $carType)
    {
        $carType->update($request->validate([
            'name_en' => 'required|string|max:100',
            'name_ar' => 'required|string|max:100'
        ]));

        return response()->json($carType);
    }

    public function destroy(CarType $carType)
    {
        $carType->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
