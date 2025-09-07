<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $items = City::orderBy('id', 'asc')->paginate(15);
        return view('cities.index', compact('items'));
    }

    public function create()
    {
        return view('cities.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:cities,name'],
            'name_ar' => ['required','string','max:100','unique:cities,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        City::create($data);

        return redirect()->route('cities.index')->with('success', __('cities.Created successfully'));
    }

    public function show(City $city)
    {
        return view('cities.show', ['item' => $city]);
    }

    public function edit(City $city)
    {
        return view('cities.edit', ['item' => $city]);
    }

    public function update(Request $request, City $city)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:cities,name,'.$city->id],
            'name_ar' => ['required','string','max:100','unique:cities,name_ar,'.$city->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $city->update($data);

        return redirect()->route('cities.index')->with('success', __('cities.Updated successfully'));
    }

    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('cities.index')->with('success', __('cities.Deleted successfully'));
    }
}

