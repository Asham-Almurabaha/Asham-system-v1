<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Cars\Entities\Car;
use Modules\Cars\Http\Requests\CarRequest;
use Modules\Org\Models\Branch;

class CarController extends Controller
{
    public function index(Request $request): View
    {
        $query = Car::query();
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($year = $request->input('year')) {
            $query->where('year', $year);
        }
        if ($branch = $request->input('branch_id')) {
            $query->where('branch_id', $branch);
        }
        if ($brand = $request->input('brand')) {
            $query->where('brand', 'like', "%$brand%");
        }
        $cars = $query->paginate();
        $branches = Branch::all();
        return view('cars::index', compact('cars', 'branches'));
    }

    public function create(): View
    {
        $branches = Branch::all();
        return view('cars::create', ['car' => new Car(), 'branches' => $branches]);
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
        return view('cars::edit', compact('car', 'branches'));
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
