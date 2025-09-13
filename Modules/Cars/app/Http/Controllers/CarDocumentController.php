<?php

namespace Modules\Cars\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Modules\Cars\Entities\{Car, CarDocument};
use Modules\Cars\Entities\Lookups\CarDocumentDataType;

class CarDocumentController extends Controller
{
    public function index(Car $car): View
    {
        $documents = $car->documents()->with('dataType')->latest()->get();
        $types = CarDocumentDataType::all();
        return view('cars::documents.index', compact('car', 'documents', 'types'));
    }

    public function store(Request $request, Car $car): RedirectResponse
    {
        $data = $request->validate([
            'car_document_data_type_id' => ['required', 'exists:car_document_data_types,id'],
            'value' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $car->documents()->create($data);

        return redirect()->route('cars.documents.index', $car)
            ->with('success', __('cars::documents.Created successfully'));
    }

    public function destroy(Car $car, CarDocument $document): RedirectResponse
    {
        $document->delete();
        return redirect()->route('cars.documents.index', $car)
            ->with('success', __('cars::documents.Deleted successfully'));
    }
}
