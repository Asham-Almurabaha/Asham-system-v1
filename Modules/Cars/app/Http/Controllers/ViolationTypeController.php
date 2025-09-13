<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\ViolationType;

class ViolationTypeController extends Controller
{
    public function index()
    {
        $items = ViolationType::orderBy('id')->paginate(15);
        return view('cars::violation-types.index', compact('items'));
    }

    public function create()
    {
        return view('cars::violation-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:violation_types,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:violation_types,name_ar'],
        ]);
        ViolationType::create($data);

        return redirect()->route('violation-types.index')
            ->with('success', __('cars::violation-types.Created successfully'));
    }

    public function edit(ViolationType $violationType)
    {
        return view('cars::violation-types.edit', ['item' => $violationType]);
    }

    public function update(Request $request, ViolationType $violationType)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:violation_types,name_en,' . $violationType->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:violation_types,name_ar,' . $violationType->id],
        ]);
        $violationType->update($data);

        return redirect()->route('violation-types.index')
            ->with('success', __('cars::violation-types.Updated successfully'));
    }

    public function destroy(ViolationType $violationType)
    {
        $violationType->delete();

        return redirect()->route('violation-types.index')
            ->with('success', __('cars::violation-types.Deleted successfully'));
    }
}
