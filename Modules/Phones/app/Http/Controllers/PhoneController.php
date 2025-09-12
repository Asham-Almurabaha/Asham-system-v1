<?php

namespace Modules\Phones\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Org\Models\Branch;
use Modules\Phones\Entities\Phone;
use Modules\Phones\Http\Requests\PhoneRequest;

class PhoneController extends Controller
{
    public function index(Request $request): View
    {
        $query = Phone::query();
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($brand = $request->input('brand')) {
            $query->where('brand', 'like', "%$brand%");
        }
        if ($branch = $request->input('branch_id')) {
            $query->where('branch_id', $branch);
        }
        if (($hasLine = $request->input('has_line')) !== null) {
            $hasLine === '1' ? $query->whereNotNull('line_number') : $query->whereNull('line_number');
        }
        $phones = $query->paginate();
        $branches = Branch::all();
        return view('phones::index', compact('phones', 'branches'));
    }

    public function create(): View
    {
        $branches = Branch::all();
        return view('phones::create', ['phone' => new Phone(), 'branches' => $branches]);
    }

    public function store(PhoneRequest $request): RedirectResponse
    {
        Phone::create($request->validated());
        return redirect()->route('phones.index')->with('success', __('phones::phones.Created successfully'));
    }

    public function show(Phone $phone): View
    {
        return view('phones::show', compact('phone'));
    }

    public function edit(Phone $phone): View
    {
        $branches = Branch::all();
        return view('phones::edit', compact('phone', 'branches'));
    }

    public function update(PhoneRequest $request, Phone $phone): RedirectResponse
    {
        $phone->update($request->validated());
        return redirect()->route('phones.index')->with('success', __('phones::phones.Updated successfully'));
    }

    public function destroy(Phone $phone): RedirectResponse
    {
        if ($phone->currentAssignment) {
            return redirect()->route('phones.index')->withErrors(__('phones::phones.Cannot delete assigned'));
        }
        $phone->delete();
        return redirect()->route('phones.index')->with('success', __('phones::phones.Deleted successfully'));
    }
}
