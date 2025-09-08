<?php

namespace Modules\ResidencyStatuses\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ResidencyStatuses\Models\ResidencyStatus;

class ResidencyStatusController extends Controller
{
    public function index()
    {
        $items = ResidencyStatus::orderBy('id', 'asc')->paginate(15);
        return view('residencystatuses::index', compact('items'));
    }

    public function create()
    {
        return view('residencystatuses::create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:residency_statuses,name'],
            'name_ar' => ['required','string','max:100','unique:residency_statuses,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        ResidencyStatus::create($data);

        return redirect()->route('residency-statuses.index')->with('success', __('residencystatuses.Created successfully'));
    }

    public function show(ResidencyStatus $residencyStatus)
    {
        return view('residencystatuses::show', ['item' => $residencyStatus]);
    }

    public function edit(ResidencyStatus $residencyStatus)
    {
        return view('residencystatuses::edit', ['item' => $residencyStatus]);
    }

    public function update(Request $request, ResidencyStatus $residencyStatus)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:residency_statuses,name,'.$residencyStatus->id],
            'name_ar' => ['required','string','max:100','unique:residency_statuses,name_ar,'.$residencyStatus->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $residencyStatus->update($data);

        return redirect()->route('residency-statuses.index')->with('success', __('residencystatuses.Updated successfully'));
    }

    public function destroy(ResidencyStatus $residencyStatus)
    {
        $residencyStatus->delete();
        return redirect()->route('residency-statuses.index')->with('success', __('residencystatuses.Deleted successfully'));
    }
}

