<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employees\Models\Employee;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;
use Modules\Org\Models\Job;
use Modules\Nationalities\Models\Nationality;
use Modules\Org\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    private const DISK = 'public';
    private const DIR  = 'employees';
    private const RESIDENCY_DIR = 'employee-residencies';
    public function index()
    {
        $items = Employee::with(['company','branch','job'])->orderBy('id','asc')->paginate(15);
        return view('employees::index', compact('items'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobs = Job::where('is_active', true)->orderBy('name')->get();
        $nationalities = Nationality::where('is_active', true)->orderBy('name')->get();
        $companies = Company::orderBy('name_en')->get();
        return view('employees::create', compact('branches','departments','jobs','nationalities','companies'));
    }

    public function store(Request $request)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'first_name_ar' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'last_name_ar' => ['required','string','max:100'],
            'email' => ['required','email','unique:employees,email'],
            'phones' => ['nullable','array'],
            'phones.*' => ['nullable','string','max:20'],
            'hire_date' => ['nullable','date'],
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['required','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'job_id' => ['nullable','exists:jobs,id'],
            'nationality_id' => ['nullable','exists:nationalities,id'],
            'photo' => ['nullable','mimes:png,jpg,jpeg,gif,webp,svg','mimetypes:image/png,image/jpeg,image/gif,image/webp,image/svg+xml','max:4096'],
            'residency_absher_id_image' => ['nullable','image'],
            'residency_tawakkalna_id_image' => ['nullable','image'],
            'residency_expiry_date' => ['nullable','date'],
            'residency_employer_name' => ['nullable','string','max:100'],
            'residency_employer_id' => ['nullable','string','max:50'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $phones = $data['phones'] ?? [];
        $residencyData = [
            'expiry_date' => $data['residency_expiry_date'] ?? null,
            'employer_name' => $data['residency_employer_name'] ?? null,
            'employer_id' => $data['residency_employer_id'] ?? null,
        ];
        unset($data['phones'], $data['residency_absher_id_image'], $data['residency_tawakkalna_id_image'], $data['residency_expiry_date'], $data['residency_employer_name'], $data['residency_employer_id']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeFile($request->file('photo'));
        }

        if ($request->hasFile('residency_absher_id_image')) {
            $residencyData['absher_id_image'] = $request->file('residency_absher_id_image')->store(self::RESIDENCY_DIR, self::DISK);
        }

        if ($request->hasFile('residency_tawakkalna_id_image')) {
            $residencyData['tawakkalna_id_image'] = $request->file('residency_tawakkalna_id_image')->store(self::RESIDENCY_DIR, self::DISK);
        }

        $employee = Employee::create($data);
        foreach ($phones as $phone) {
            if ($phone) {
                $employee->phones()->create(['phone' => $phone]);
            }
        }

        if (array_filter($residencyData)) {
            $employee->residencies()->create($residencyData);
        }

        return redirect()->route('employees.index')->with('success', __('employees.Created successfully'));
    }

    public function show(Employee $employee)
    {
        $employee->load(['phones','company','branch','department','job','manager','documents']);
        return view('employees::show', ['item' => $employee]);
    }

    public function edit(Employee $employee)
    {
        $employee->load('phones','residencies');
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobs = Job::where('is_active', true)->orderBy('name')->get();
        $nationalities = Nationality::where('is_active', true)->orderBy('name')->get();
        $companies = Company::orderBy('name_en')->get();
        return view('employees::edit', ['item' => $employee, 'branches' => $branches, 'departments' => $departments, 'jobs' => $jobs, 'nationalities' => $nationalities, 'companies'=>$companies]);
    }

    public function update(Request $request, Employee $employee)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $residency = $employee->residencies()->first();
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'first_name_ar' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'last_name_ar' => ['required','string','max:100'],
            'email' => ['required','email','unique:employees,email,'.$employee->id],
            'phones' => ['nullable','array'],
            'phones.*' => ['nullable','string','max:20'],
            'hire_date' => ['nullable','date'],
            'company_id' => ['nullable','exists:companies,id'],
            'branch_id' => ['required','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'job_id' => ['nullable','exists:jobs,id'],
            'nationality_id' => ['nullable','exists:nationalities,id'],
            'photo' => ['nullable','mimes:png,jpg,jpeg,gif,webp,svg','mimetypes:image/png,image/jpeg,image/gif,image/webp,image/svg+xml','max:4096'],
            'remove_photo' => ['sometimes','boolean'],
            'residency_absher_id_image' => ['nullable','image'],
            'residency_tawakkalna_id_image' => ['nullable','image'],
            'residency_expiry_date' => ['nullable','date'],
            'residency_employer_name' => ['nullable','string','max:100'],
            'residency_employer_id' => ['nullable','string','max:50'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $phones = $data['phones'] ?? [];
        $residencyData = [
            'expiry_date' => $data['residency_expiry_date'] ?? null,
            'employer_name' => $data['residency_employer_name'] ?? null,
            'employer_id' => $data['residency_employer_id'] ?? null,
        ];
        unset($data['phones'], $data['residency_absher_id_image'], $data['residency_tawakkalna_id_image'], $data['residency_expiry_date'], $data['residency_employer_name'], $data['residency_employer_id']);
        if ($request->boolean('remove_photo')) {
            $this->deleteIfExists($employee->photo);
            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            $this->deleteIfExists($employee->photo);
            $data['photo'] = $this->storeFile($request->file('photo'));
        }

        if ($request->hasFile('residency_absher_id_image')) {
            $this->deleteIfExists($residency?->absher_id_image);
            $residencyData['absher_id_image'] = $request->file('residency_absher_id_image')->store(self::RESIDENCY_DIR, self::DISK);
        }

        if ($request->hasFile('residency_tawakkalna_id_image')) {
            $this->deleteIfExists($residency?->tawakkalna_id_image);
            $residencyData['tawakkalna_id_image'] = $request->file('residency_tawakkalna_id_image')->store(self::RESIDENCY_DIR, self::DISK);
        }

        $employee->update($data);
        $employee->phones()->delete();
        foreach ($phones as $phone) {
            if ($phone) {
                $employee->phones()->create(['phone' => $phone]);
            }
        }

        if ($residency) {
            $residency->update($residencyData);
        } elseif (array_filter($residencyData)) {
            $employee->residencies()->create($residencyData);
        }

        return redirect()->route('employees.index')->with('success', __('employees.Updated successfully'));
    }

    public function destroy(Employee $employee)
    {
        $this->deleteIfExists($employee->photo);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', __('employees.Deleted successfully'));
    }

    private function storeFile(UploadedFile $file): string
    {
        return $file->store(self::DIR, self::DISK);
    }

    private function deleteIfExists(?string $path): void
    {
        if ($path && Storage::disk(self::DISK)->exists($path)) {
            try {
                Storage::disk(self::DISK)->delete($path);
            } catch (\Throwable $e) {
                // ignore
            }
        }
    }
}
