<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Title;
use Modules\Org\Models\Company;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;

class TitleController extends Controller
{
    public function index()
    {
        $items = Title::with(['company','branch','department'])->orderBy('id', 'asc')->paginate(15);
        return view('org::titles.index', compact('items'));
    }

    public function create()
    {
        $companies = Company::orderBy('name_en')->get();
        $branches = Branch::orderBy('name_en')->get();
        $departments = Department::orderBy('name_en')->get();
        return view('org::titles.create', compact('companies','branches','departments'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['nullable','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:titles,name_en'],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Title::create($data);

        return redirect()->route('titles.index')->with('success', __('org::titles.Created successfully'));
    }

    public function show(Title $title)
    {
        return view('org::titles.show', ['item' => $title]);
    }

    public function edit(Title $title)
    {
        $companies = Company::orderBy('name_en')->get();
        $branches = Branch::orderBy('name_en')->get();
        $departments = Department::orderBy('name_en')->get();
        return view('org::titles.edit', ['item' => $title, 'companies' => $companies, 'branches' => $branches, 'departments' => $departments]);
    }

    public function update(Request $request, Title $title)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['nullable','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'name_en' => ['required','string','max:100','unique:titles,name_en,'.$title->id],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar,'.$title->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $title->update($data);

        return redirect()->route('titles.index')->with('success', __('org::titles.Updated successfully'));
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return redirect()->route('titles.index')->with('success', __('org::titles.Deleted successfully'));
    }
}
