<?php

namespace Modules\Org\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Org\Models\Department;

class DepartmentController extends Controller
{
    public function index()
    {
        $items = Department::orderBy('id', 'asc')->paginate(15);
        return view('org::departments.index', compact('items'));
    }

    public function create()
    {
        return view('org::departments.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:departments,name_en'],
            'name_ar' => ['required','string','max:100','unique:departments,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Department::create($data);

        return redirect()->route('departments.index')->with('success', __('org::departments.Created successfully'));
    }

    public function show(Department $department)
    {
        return view('org::departments.show', ['item' => $department]);
    }

    public function edit(Department $department)
    {
        return view('org::departments.edit', ['item' => $department]);
    }

    public function update(Request $request, Department $department)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name_en' => ['required','string','max:100','unique:departments,name_en,'.$department->id],
            'name_ar' => ['required','string','max:100','unique:departments,name_ar,'.$department->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $department->update($data);

        return redirect()->route('departments.index')->with('success', __('org::departments.Updated successfully'));
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', __('org::departments.Deleted successfully'));
    }
}
