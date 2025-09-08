<?php

namespace Modules\Titles\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Titles\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        $items = Title::orderBy('id', 'asc')->paginate(15);
        return view('titles::index', compact('items'));
    }

    public function create()
    {
        return view('titles::create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:titles,name'],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        Title::create($data);

        return redirect()->route('titles.index')->with('success', __('titles.Created successfully'));
    }

    public function show(Title $title)
    {
        return view('titles::show', ['item' => $title]);
    }

    public function edit(Title $title)
    {
        return view('titles::edit', ['item' => $title]);
    }

    public function update(Request $request, Title $title)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'name' => ['required','string','max:100','unique:titles,name,'.$title->id],
            'name_ar' => ['required','string','max:100','unique:titles,name_ar,'.$title->id],
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

