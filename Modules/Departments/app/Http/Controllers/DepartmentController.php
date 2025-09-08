<?php

namespace Modules\Departments\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Departments\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $items = Department::orderBy('id', 'asc')->paginate(15);
        return view('departments::index', compact('items'));
    }

    public function create()
    {
        return view('departments::create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:departments,name'],
            'name_ar' => ['required','string','max:100','unique:departments,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Department::create($data);

        return redirect()->route('departments.index')->with('success', __('departments.Created successfully'));
    }

    public function show(Department $department)
    {
        return view('departments::show', ['item' => $department]);
    }

    public function edit(Department $department)
    {
        return view('departments::edit', ['item' => $department]);
    }

    public function update(Request $request, Department $department)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:departments,name,'.$department->id],
            'name_ar' => ['required','string','max:100','unique:departments,name_ar,'.$department->id],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $department->update($data);

        return redirect()->route('departments.index')->with('success', __('departments.Updated successfully'));
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', __('departments.Deleted successfully'));
    }
}
