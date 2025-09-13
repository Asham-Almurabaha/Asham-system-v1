<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Cars\Entities\{Car, OilChange};

class OilChangeController extends Controller
{
    public function index(Car $car): View
    {
        $oilChanges = $car->oilChanges()->latest()->get();
        return view('cars::oil_changes.index', compact('car', 'oilChanges'));
    }

    public function store(Request $request, Car $car): RedirectResponse
    {
        $data = $request->validate([
            'changed_at' => 'required|date',
            'mileage' => 'nullable|integer',
            'notes' => 'nullable|string',
        ]);

        $car->oilChanges()->create($data);

        return redirect()->route('cars.oil-changes.index', $car);
    }
}
