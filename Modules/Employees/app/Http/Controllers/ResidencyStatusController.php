<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employees\Models\ResidencyStatus;

class ResidencyStatusController extends Controller
{
    public function index()
    {
        $items = ResidencyStatus::orderBy('id', 'asc')->paginate(15);
        return view('employees::residencystatuses.index', compact('items'));
    }

    public function create()
    {
        return view('employees::residencystatuses.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:residency_statuses,name_en'],
            'name_ar' => ['required','string','max:100','unique:residency_statuses,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        ResidencyStatus::create($data);

        return redirect()->route('residency-statuses.index')->with('success', __('employees::residencystatuses.Created successfully'));
    }

    public function show(ResidencyStatus $residencyStatus)
    {
        return view('employees::residencystatuses.show', ['item' => $residencyStatus]);
    }

    public function edit(ResidencyStatus $residencyStatus)
    {
        return view('employees::residencystatuses.edit', ['item' => $residencyStatus]);
    }

    public function update(Request $request, ResidencyStatus $residencyStatus)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:residency_statuses,name_en,'.$residencyStatus->id],
            'name_ar' => ['required','string','max:100','unique:residency_statuses,name_ar,'.$residencyStatus->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $residencyStatus->update($data);

        return redirect()->route('residency-statuses.index')->with('success', __('employees::residencystatuses.Updated successfully'));
    }

    public function destroy(ResidencyStatus $residencyStatus)
    {
        $residencyStatus->delete();
        return redirect()->route('residency-statuses.index')->with('success', __('employees::residencystatuses.Deleted successfully'));
    }
}

