<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Company;

class BranchController extends Controller
{
    public function index()
    {
        $items = Branch::with('company')->orderBy('id', 'asc')->paginate(15);
        return view('org::branches.index', compact('items'));
    }

    public function create()
    {
        $companies = Company::orderBy('name_en')->get();
        return view('org::branches.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'name_en' => ['required','string','max:100','unique:branches,name_en'],
            'name_ar' => ['required','string','max:100','unique:branches,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Branch::create($data);

        return redirect()->route('branches.index')->with('success', __('org::branches.Created successfully'));
    }

    public function show(Branch $branch)
    {
        return view('org::branches.show', ['item' => $branch]);
    }

    public function edit(Branch $branch)
    {
        $companies = Company::orderBy('name_en')->get();
        return view('org::branches.edit', ['item' => $branch, 'companies' => $companies]);
    }

    public function update(Request $request, Branch $branch)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'company_id' => ['nullable','exists:companies,id'],
            'name_en' => ['required','string','max:100','unique:branches,name_en,'.$branch->id],
            'name_ar' => ['required','string','max:100','unique:branches,name_ar,'.$branch->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $branch->update($data);

        return redirect()->route('branches.index')->with('success', __('org::branches.Updated successfully'));
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', __('org::branches.Deleted successfully'));
    }
}
