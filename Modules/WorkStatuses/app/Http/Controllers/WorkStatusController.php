<?php

namespace Modules\WorkStatuses\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\WorkStatuses\Models\WorkStatus;

class WorkStatusController extends Controller
{
    public function index()
    {
        $items = WorkStatus::orderBy('id', 'asc')->paginate(15);
        return view('workstatuses::index', compact('items'));
    }

    public function create()
    {
        return view('workstatuses::create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:work_statuses,name'],
            'name_ar' => ['required','string','max:100','unique:work_statuses,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        WorkStatus::create($data);

        return redirect()->route('work-statuses.index')->with('success', __('workstatuses.Created successfully'));
    }

    public function show(WorkStatus $workStatus)
    {
        return view('workstatuses::show', ['item' => $workStatus]);
    }

    public function edit(WorkStatus $workStatus)
    {
        return view('workstatuses::edit', ['item' => $workStatus]);
    }

    public function update(Request $request, WorkStatus $workStatus)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:work_statuses,name,'.$workStatus->id],
            'name_ar' => ['required','string','max:100','unique:work_statuses,name_ar,'.$workStatus->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $workStatus->update($data);

        return redirect()->route('work-statuses.index')->with('success', __('workstatuses.Updated successfully'));
    }

    public function destroy(WorkStatus $workStatus)
    {
        $workStatus->delete();
        return redirect()->route('work-statuses.index')->with('success', __('workstatuses.Deleted successfully'));
    }
}

