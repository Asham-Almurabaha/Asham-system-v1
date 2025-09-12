<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $items = Company::orderBy('id', 'asc')->paginate(15);
        return view('org::companies.index', compact('items'));
    }

    public function create()
    {
        return view('org::companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:companies,name_en'],
            'name_ar' => ['required','string','max:100','unique:companies,name_ar'],
            'cr_number' => ['nullable','string','max:50'],
            'vat_number' => ['nullable','string','max:50'],
            'iban' => ['nullable','string','max:50'],
        ]);
        Company::create($data);

        return redirect()->route('companies.index')->with('success', __('org::companies.Created successfully'));
    }

    public function show(Company $company)
    {
        return view('org::companies.show', ['item' => $company]);
    }

    public function edit(Company $company)
    {
        return view('org::companies.edit', ['item' => $company]);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:companies,name_en,'.$company->id],
            'name_ar' => ['required','string','max:100','unique:companies,name_ar,'.$company->id],
            'cr_number' => ['nullable','string','max:50'],
            'vat_number' => ['nullable','string','max:50'],
            'iban' => ['nullable','string','max:50'],
        ]);
        $company->update($data);

        return redirect()->route('companies.index')->with('success', __('org::companies.Updated successfully'));
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', __('org::companies.Deleted successfully'));
    }
}
