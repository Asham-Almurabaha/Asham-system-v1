<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employees\Models\Employee;

class EmployeeResidencyController extends Controller
{
    private const DISK = 'public';
    private const DIR = 'employee-residencies';

    public function create(Employee $employee)
    {
        return view('employees::residencies.create', compact('employee'));
    }

    public function store(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'absher_id_image' => ['nullable', 'image'],
            'tawakkalna_id_image' => ['nullable', 'image'],
            'expiry_date' => ['required', 'date'],
            'employer_name' => ['nullable', 'string', 'max:100'],
            'employer_id' => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->hasFile('absher_id_image')) {
            $data['absher_id_image'] = $request->file('absher_id_image')->store(self::DIR, self::DISK);
        }

        if ($request->hasFile('tawakkalna_id_image')) {
            $data['tawakkalna_id_image'] = $request->file('tawakkalna_id_image')->store(self::DIR, self::DISK);
        }

        $employee->residencies()->create($data);

        return redirect()->route('employees.show', $employee)->with('success', __('employees::employees.Created successfully'));
    }
}
