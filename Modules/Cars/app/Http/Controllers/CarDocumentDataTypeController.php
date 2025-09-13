<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Cars\Entities\Lookups\CarDocumentDataType;

class CarDocumentDataTypeController extends Controller
{
    public function index()
    {
        $items = CarDocumentDataType::orderBy('id')->paginate(15);
        return view('cars::car-document-data-types.index', compact('items'));
    }

    public function create()
    {
        return view('cars::car-document-data-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_document_data_types,name_en'],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_document_data_types,name_ar'],
        ]);
        CarDocumentDataType::create($data);

        return redirect()->route('car-document-data-types.index')
            ->with('success', __('cars::document-data-types.Created successfully'));
    }

    public function edit(CarDocumentDataType $carDocumentDataType)
    {
        return view('cars::car-document-data-types.edit', ['item' => $carDocumentDataType]);
    }

    public function update(Request $request, CarDocumentDataType $carDocumentDataType)
    {
        $data = $request->validate([
            'name_en' => ['required', 'string', 'max:50', 'unique:car_document_data_types,name_en,' . $carDocumentDataType->id],
            'name_ar' => ['required', 'string', 'max:50', 'unique:car_document_data_types,name_ar,' . $carDocumentDataType->id],
        ]);
        $carDocumentDataType->update($data);

        return redirect()->route('car-document-data-types.index')
            ->with('success', __('cars::document-data-types.Updated successfully'));
    }

    public function destroy(CarDocumentDataType $carDocumentDataType)
    {
        $carDocumentDataType->delete();

        return redirect()->route('car-document-data-types.index')
            ->with('success', __('cars::document-data-types.Deleted successfully'));
    }
}
