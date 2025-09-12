<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarColor;

class CarColorController extends Controller
{
    public function index()
    {
        return response()->json(CarColor::all());
    }

    public function store(Request $request)
    {
        $color = CarColor::create($request->validate([
            'name_en' => 'required|string|max:50',
            'name_ar' => 'required|string|max:50'
        ]));

        return response()->json($color, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarColor $carColor)
    {
        $carColor->update($request->validate([
            'name_en' => 'required|string|max:50',
            'name_ar' => 'required|string|max:50'
        ]));

        return response()->json($carColor);
    }

    public function destroy(CarColor $carColor)
    {
        $carColor->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
