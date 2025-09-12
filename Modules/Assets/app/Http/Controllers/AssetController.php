<?php

namespace Modules\Assets\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Assets\Models\Asset;

class AssetController extends Controller
{
    public function index()
    {
        $items = Asset::orderBy('id')->get();
        return view('assets::index', compact('items'));
    }

    public function create()
    {
        return view('assets::create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => ['required','string'],
            'serial' => ['nullable','string'],
            'description' => ['nullable','string'],
            'cost' => ['nullable','numeric'],
            'status' => ['nullable','string'],
        ]);
        try {
            Asset::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.assets.index');
    }

    public function edit(Asset $asset)
    {
        return view('assets::create', ['item'=>$asset]);
    }

    public function update(Request $request, Asset $asset)
    {
        $data = $request->validate([
            'type' => ['required','string'],
            'serial' => ['nullable','string'],
            'description' => ['nullable','string'],
            'cost' => ['nullable','numeric'],
            'status' => ['nullable','string'],
        ]);
        try {
            $asset->update($data);
            session()->flash('success', __('app.Updated'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return redirect()->route('hr.assets.index');
    }

    public function destroy(Asset $asset)
    {
        try {
            $asset->delete();
            session()->flash('success', __('app.Deleted'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }
}
