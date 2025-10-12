<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employees\Models\SponsorshipStatus;

class SponsorshipStatusController extends Controller
{
    public function index()
    {
        $items = SponsorshipStatus::orderBy('id', 'asc')->paginate(15);
        return view('employees::sponsorshipstatuses.index', compact('items'));
    }

    public function create()
    {
        return view('employees::sponsorshipstatuses.create');
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:100', 'unique:sponsorship_statuses,name_en'],
            'name_ar' => ['required', 'string', 'max:100', 'unique:sponsorship_statuses,name_ar'],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        SponsorshipStatus::create($data);

        return redirect()
            ->route('sponsorship-statuses.index')
            ->with('success', __('employees::sponsorshipstatuses.Created successfully'));
    }

    public function show(SponsorshipStatus $sponsorshipStatus)
    {
        return view('employees::sponsorshipstatuses.show', ['item' => $sponsorshipStatus]);
    }

    public function edit(SponsorshipStatus $sponsorshipStatus)
    {
        return view('employees::sponsorshipstatuses.edit', ['item' => $sponsorshipStatus]);
    }

    public function update(Request $request, SponsorshipStatus $sponsorshipStatus)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:100', 'unique:sponsorship_statuses,name_en,' . $sponsorshipStatus->id],
            'name_ar' => ['required', 'string', 'max:100', 'unique:sponsorship_statuses,name_ar,' . $sponsorshipStatus->id],
            'is_active' => ['boolean'],
        ]);

        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $sponsorshipStatus->update($data);

        return redirect()
            ->route('sponsorship-statuses.index')
            ->with('success', __('employees::sponsorshipstatuses.Updated successfully'));
    }

    public function destroy(SponsorshipStatus $sponsorshipStatus)
    {
        $sponsorshipStatus->delete();

        return redirect()
            ->route('sponsorship-statuses.index')
            ->with('success', __('employees::sponsorshipstatuses.Deleted successfully'));
    }
}
