<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;
use Modules\Cars\Entities\Lookups\CarYear;

class CarYearController extends Controller
{
    public function index()
    {
        return response()->json(CarYear::all());
    }

    public function store(Request $request)
    {
        $year = CarYear::create($request->validate([
            'year' => 'required|integer'
        ]));

        return response()->json($year, Response::HTTP_CREATED);
    }

    public function update(Request $request, CarYear $carYear)
    {
        $carYear->update($request->validate([
            'year' => 'required|integer'
        ]));

        return response()->json($carYear);
    }

    public function destroy(CarYear $carYear)
    {
        $carYear->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
