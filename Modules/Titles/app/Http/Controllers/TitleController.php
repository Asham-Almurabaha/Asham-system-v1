<?php

namespace Modules\Titles\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Titles\Models\Title;
use Modules\Departments\Models\Department;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $items = Title::orderBy('id', 'asc')->with('department')->paginate(15);
        return view('titles::index', compact('items'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('titles::create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:titles,name'],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar'],
            'department_id' => ['nullable','exists:departments,id'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Title::create($data);

        return redirect()->route('titles.index')->with('success', __('titles.Created successfully'));
    }

    public function show(Title $title)
    {
        return view('titles::show', ['item' => $title->load('department')]);
    }

    public function edit(Title $title)
    {
        $departments = Department::orderBy('name')->get();
        return view('titles::edit', ['item' => $title, 'departments' => $departments]);
    }

    public function update(Request $request, Title $title)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:titles,name,'.$title->id],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar,'.$title->id],
            'department_id' => ['nullable','exists:departments,id'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $title->update($data);

        return redirect()->route('titles.index')->with('success', __('titles.Updated successfully'));
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return redirect()->route('titles.index')->with('success', __('titles.Deleted successfully'));
    }
}
