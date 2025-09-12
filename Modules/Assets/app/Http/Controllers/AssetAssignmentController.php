<?php

namespace Modules\Assets\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Assets\Models\Asset;
use Modules\Assets\Models\AssetAssignment;

class AssetAssignmentController extends Controller
{
    public function store(Asset $asset, Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required','exists:employees,id'],
            'assigned_at' => ['required','date'],
            'condition_out' => ['nullable','string'],
        ]);
        $exists = AssetAssignment::where('asset_id', $asset->id)->whereNull('returned_at')->exists();
        if ($exists) {
            return back()->with('error', __('app.Validation errors'));
        }
        $data['asset_id'] = $asset->id;
        try {
            AssetAssignment::create($data);
            session()->flash('success', __('app.Saved'));
        } catch (\Exception $e) {
            session()->flash('error', __('app.Validation errors'));
        }
        return back();
    }

    public function return(Asset $asset, Request $request)
    {
        $data = $request->validate([
            'returned_at' => ['required','date'],
            'condition_in' => ['nullable','string'],
        ]);
        $assignment = AssetAssignment::where('asset_id', $asset->id)->whereNull('returned_at')->first();
        if (!$assignment) {
            return back()->with('error', __('app.Validation errors'));
        }
        $assignment->update($data);
        return back()->with('success', __('app.Updated'));
    }
}
