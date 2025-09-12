<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Job;
use Modules\Org\Models\Company;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;

class JobController extends Controller
{
    public function index()
    {
        $items = Job::with(['company','branch','department'])->orderBy('id', 'asc')->paginate(15);
        return view('org::jobs.index', compact('items'));
    }

    public function create()
    {
        $companies = Company::orderBy('name_en')->get();
        $branches = Branch::orderBy('name_en')->get();
        $departments = Department::orderBy('name_en')->get();
        return view('org::jobs.create', compact('companies','branches','departments'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['nullable','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:jobs,name_en'],
            'name_ar' => ['required','string','max:100','unique:jobs,name_ar'],
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
        $companies = Company::orderBy('name_en')->get();
        $branches = Branch::orderBy('name_en')->get();
        $departments = Department::orderBy('name_en')->get();
        return view('org::jobs.edit', ['item' => $job, 'companies' => $companies, 'branches' => $branches, 'departments' => $departments]);
    }

    public function update(Request $request, Job $job)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['nullable','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:jobs,name_en,'.$job->id],
            'name_ar' => ['required','string','max:100','unique:jobs,name_ar,'.$job->id],
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
