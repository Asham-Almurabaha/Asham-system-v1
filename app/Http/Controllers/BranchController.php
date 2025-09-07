<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $query = Branch::orderBy('id', 'asc');
        if (!Auth::user()->hasRole('admin')) {
            $query->where('id', Auth::user()->branch_id);
        }
        $items = $query->paginate(15);
        return view('branches.index', compact('items'));
    }

    public function create()
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('branches.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'name_ar' => ['required','string','max:100'],
            'city_id' => ['required','exists:cities,id'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Branch::create($data);

        return redirect()->route('branches.index')->with('success', __('branches.Created successfully'));
    }

    public function show(Branch $branch)
    {
        return view('branches.show', ['item' => $branch]);
    }

    public function edit(Branch $branch)
    {
        $cities = City::where('is_active', true)->orderBy('name')->get();
        return view('branches.edit', ['item' => $branch, 'cities' => $cities]);
    }

    public function update(Request $request, Branch $branch)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'name_ar' => ['required','string','max:100'],
            'city_id' => ['required','exists:cities,id'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $branch->update($data);

        return redirect()->route('branches.index')->with('success', __('branches.Updated successfully'));
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', __('branches.Deleted successfully'));
    }
}

