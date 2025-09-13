<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarColor;

class CarColorController extends Controller
{
    public function index()
    {
        $items = CarColor::orderBy('id')->paginate(15);
        return view('cars::car-colors.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-colors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_colors,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_colors,name_ar'],
        ]);
        CarColor::create($data);

        return redirect()->route('car-colors.index')
            ->with('success', __('cars::colors.Created successfully'));
    }

    public function edit(CarColor $carColor)
    {
        return view('cars::car-colors.edit', ['item' => $carColor]);
    }

    public function update(Request $request, CarColor $carColor)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_colors,name_en,' . $carColor->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_colors,name_ar,' . $carColor->id],
        ]);
        $carColor->update($data);

        return redirect()->route('car-colors.index')
            ->with('success', __('cars::colors.Updated successfully'));
    }

    public function destroy(CarColor $carColor)
    {
        $carColor->delete();

        return redirect()->route('car-colors.index')
            ->with('success', __('cars::colors.Deleted successfully'));
    }
}
