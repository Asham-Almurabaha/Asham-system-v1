<?php

namespace Modules\Motorcycles\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Motorcycles\Entities\Motorcycle;
use Modules\Motorcycles\Http\Requests\MotorcycleRequest;

class MotorcycleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Motorcycle::query();
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
        $motorcycles = $query->paginate();
        return view('motorcycles::index', compact('motorcycles'));
    }

    public function create(): View
    {
        return view('motorcycles::form', ['motorcycle' => new Motorcycle()]);
    }

    public function store(MotorcycleRequest $request): RedirectResponse
    {
        Motorcycle::create($request->validated());
        return redirect()->route('motorcycles.index')->with('success', __('motorcycles::motorcycles.Created successfully'));
    }

    public function show(Motorcycle $motorcycle): View
    {
        return view('motorcycles::show', compact('motorcycle'));
    }

    public function edit(Motorcycle $motorcycle): View
    {
        return view('motorcycles::form', compact('motorcycle'));
    }

    public function update(MotorcycleRequest $request, Motorcycle $motorcycle): RedirectResponse
    {
        $motorcycle->update($request->validated());
        return redirect()->route('motorcycles.index')->with('success', __('motorcycles::motorcycles.Updated successfully'));
    }

    public function destroy(Motorcycle $motorcycle): RedirectResponse
    {
        if ($motorcycle->currentAssignment) {
            return redirect()->route('motorcycles.index')->withErrors(__('motorcycles::motorcycles.Cannot delete assigned'));
        }
        $motorcycle->delete();
        return redirect()->route('motorcycles.index')->with('success', __('motorcycles::motorcycles.Deleted successfully'));
    }
}
