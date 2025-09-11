<?php

namespace Modules\Documents\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Employees\Models\Employee;
use Modules\Documents\Models\Document;

class EmployeeDocumentController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'type' => 'required|string|max:100',
            'number' => 'nullable|string|max:100',
            'issuer' => 'nullable|string|max:150',
            'issue_at' => 'nullable|date',
            'expire_at' => 'nullable|date',
            'file' => 'nullable|file',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('docs', 'public');
        }

        $employee->documents()->create($data);

        return back()->with('success', __('documents::documents.uploaded'));
    }

    public function destroy(Document $document)
    {
        $document->delete();
        return back()->with('success', __('documents::documents.deleted'));
    }
}
