<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Nationality;

class NationalityController extends Controller
{
    public function index()
    {
        $items = Nationality::orderBy('id', 'asc')->paginate(15);
        return view('org::nationalities.index', compact('items'));
    }

    public function create()
    {
        return view('org::nationalities.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:nationalities,name_en'],
            'name_ar' => ['required','string','max:100','unique:nationalities,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Nationality::create($data);

        return redirect()->route('nationalities.index')->with('success', __('org::nationalities.Created successfully'));
    }

    public function show(Nationality $nationality)
    {
        return view('org::nationalities.show', ['item' => $nationality]);
    }

    public function edit(Nationality $nationality)
    {
        return view('org::nationalities.edit', ['item' => $nationality]);
    }

    public function update(Request $request, Nationality $nationality)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:nationalities,name_en,'.$nationality->id],
            'name_ar' => ['required','string','max:100','unique:nationalities,name_ar,'.$nationality->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $nationality->update($data);

        return redirect()->route('nationalities.index')->with('success', __('org::nationalities.Updated successfully'));
    }

    public function destroy(Nationality $nationality)
    {
        $nationality->delete();
        return redirect()->route('nationalities.index')->with('success', __('org::nationalities.Deleted successfully'));
    }
}

