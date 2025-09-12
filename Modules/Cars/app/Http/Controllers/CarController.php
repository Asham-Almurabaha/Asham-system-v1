<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Cars\Entities\Car;
use Modules\Cars\Entities\Lookups\{CarBrand, CarColor, CarModel, CarStatus, CarType, CarYear};
use Modules\Cars\Http\Requests\CarRequest;
use Modules\Org\Models\Branch;

class CarController extends Controller
{
    public function index(Request $request): View
    {
        $query = Car::query();
        if ($status = $request->input('car_status_id')) {
            $query->where('car_status_id', $status);
        }
        if ($year = $request->input('car_year_id')) {
            $query->where('car_year_id', $year);
        }
        if ($branch = $request->input('branch_id')) {
            $query->where('branch_id', $branch);
        }
        if ($brand = $request->input('car_brand_id')) {
            $query->where('car_brand_id', $brand);
        }
        $cars = $query->paginate();
        $branches = Branch::all();
        $statuses = CarStatus::all();
        return view('cars::index', compact('cars', 'branches', 'statuses'));
    }

    public function create(): View
    {
        $branches = Branch::all();
        $years = CarYear::all();
        $types = CarType::all();
        $brands = CarBrand::all();
        $models = CarModel::all();
        $colors = CarColor::all();
        $statuses = CarStatus::all();
        return view('cars::create', [
            'car' => new Car(),
            'branches' => $branches,
            'years' => $years,
            'types' => $types,
            'brands' => $brands,
            'models' => $models,
            'colors' => $colors,
            'statuses' => $statuses,
        ]);
    }

    public function store(CarRequest $request): RedirectResponse
    {
        Car::create($request->validated());
        return redirect()->route('cars.index')->with('success', __('cars::cars.Created successfully'));
    }

    public function show(Car $car): View
    {
        return view('cars::show', compact('car'));
    }

    public function edit(Car $car): View
    {
        $branches = Branch::all();
        $years = CarYear::all();
        $types = CarType::all();
        $brands = CarBrand::all();
        $models = CarModel::all();
        $colors = CarColor::all();
        $statuses = CarStatus::all();
        return view('cars::edit', compact('car', 'branches', 'years', 'types', 'brands', 'models', 'colors', 'statuses'));
    }

    public function update(CarRequest $request, Car $car): RedirectResponse
    {
        $car->update($request->validated());
        return redirect()->route('cars.index')->with('success', __('cars::cars.Updated successfully'));
    }

    public function destroy(Car $car): RedirectResponse
    {
        if ($car->currentAssignment) {
            return redirect()->route('cars.index')->withErrors(__('cars::cars.Cannot delete assigned'));
        }
        $car->delete();
        return redirect()->route('cars.index')->with('success', __('cars::cars.Deleted successfully'));
    }
}
