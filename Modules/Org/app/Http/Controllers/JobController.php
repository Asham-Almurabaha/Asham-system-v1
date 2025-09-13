<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Job;
use Modules\Org\Models\Department;

class JobController extends Controller
{
    public function index()
    {
        $items = Job::with('department')->orderBy('id', 'asc')->paginate(15);
        return view('org::jobs.index', compact('items'));
    }

    public function create()
    {
        $departments = Department::orderBy('name_en')->get();
        return view('org::jobs.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:org_jobs,name_en'],
            'name_ar' => ['required','string','max:100','unique:org_jobs,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Job::create($data);

        return redirect()->route('jobs.index')->with('success', __('org::jobs.Created successfully'));
    }

    public function show(Job $job)
    {
        return view('org::jobs.show', ['item' => $job]);
    }

    public function edit(Job $job)
    {
        $departments = Department::orderBy('name_en')->get();
        return view('org::jobs.edit', ['item' => $job, 'departments' => $departments]);
    }

    public function update(Request $request, Job $job)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:org_jobs,name_en,'.$job->id],
            'name_ar' => ['required','string','max:100','unique:org_jobs,name_ar,'.$job->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $job->update($data);

        return redirect()->route('jobs.index')->with('success', __('org::jobs.Updated successfully'));
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', __('org::jobs.Deleted successfully'));
    }
}
