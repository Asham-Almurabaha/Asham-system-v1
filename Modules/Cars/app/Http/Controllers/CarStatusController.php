<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarStatus;

class CarStatusController extends Controller
{
    public function index()
    {
        return response()->json(CarStatus::all());
    }

    public function store(Request $request)
    {
        $status = CarStatus::create($request->validate([
            'name_en' => 'required|string|max:50',
            'name_ar' => 'required|string|max:50'
        ]));

        return response()->json($status, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarStatus $carStatus)
    {
        $carStatus->update($request->validate([
            'name_en' => 'required|string|max:50',
            'name_ar' => 'required|string|max:50'
        ]));

        return response()->json($carStatus);
    }

    public function destroy(CarStatus $carStatus)
    {
        $carStatus->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
