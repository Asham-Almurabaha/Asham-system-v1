<?php

namespace Modules\Employees\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Employees\Models\Employee;
use Modules\Branches\Models\Branch;
use Modules\Departments\Models\Department;
use Modules\Titles\Models\Title;
use Modules\Nationalities\Models\Nationality;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    private const DISK = 'public';
    private const DIR  = 'employees';
    public function index()
    {
        $items = Employee::with(['branch','title'])->orderBy('id','asc')->paginate(15);
        return view('employees::index', compact('items'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $titles = Title::where('is_active', true)->orderBy('name')->get();
        $nationalities = Nationality::where('is_active', true)->orderBy('name')->get();
        return view('employees::create', compact('branches','departments','titles','nationalities'));
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
            'branch_id' => ['required','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'title_id' => ['nullable','exists:titles,id'],
            'nationality_id' => ['nullable','exists:nationalities,id'],
            'photo' => ['nullable','mimes:png,jpg,jpeg,gif,webp,svg','mimetypes:image/png,image/jpeg,image/gif,image/webp,image/svg+xml','max:4096'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $phones = $data['phones'] ?? [];
        unset($data['phones']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storeFile($request->file('photo'));
        }

        $employee = Employee::create($data);
        foreach ($phones as $phone) {
            if ($phone) {
                $employee->phones()->create(['phone' => $phone]);
            }
        }

        return redirect()->route('employees.index')->with('success', __('employees.Created successfully'));
    }

    public function show(Employee $employee)
    {
        $employee->load('phones');
        return view('employees::show', ['item' => $employee]);
    }

    public function edit(Employee $employee)
    {
        $employee->load('phones');
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $titles = Title::where('is_active', true)->orderBy('name')->get();
        $nationalities = Nationality::where('is_active', true)->orderBy('name')->get();
        return view('employees::edit', ['item' => $employee, 'branches' => $branches, 'departments' => $departments, 'titles' => $titles, 'nationalities' => $nationalities]);
    }

    public function update(Request $request, Employee $employee)
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);
        $data = $request->validate([
            'first_name' => ['required','string','max:100'],
            'first_name_ar' => ['required','string','max:100'],
            'last_name' => ['required','string','max:100'],
            'last_name_ar' => ['required','string','max:100'],
            'email' => ['required','email','unique:employees,email,'.$employee->id],
            'phones' => ['nullable','array'],
            'phones.*' => ['nullable','string','max:20'],
            'hire_date' => ['nullable','date'],
            'branch_id' => ['required','exists:branches,id'],
            'department_id' => ['nullable','exists:departments,id'],
            'title_id' => ['nullable','exists:titles,id'],
            'nationality_id' => ['nullable','exists:nationalities,id'],
            'photo' => ['nullable','mimes:png,jpg,jpeg,gif,webp,svg','mimetypes:image/png,image/jpeg,image/gif,image/webp,image/svg+xml','max:4096'],
            'remove_photo' => ['sometimes','boolean'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = (bool)($data['is_active'] ?? true);
        $phones = $data['phones'] ?? [];
        unset($data['phones']);
        if ($request->boolean('remove_photo')) {
            $this->deleteIfExists($employee->photo);
            $data['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            $this->deleteIfExists($employee->photo);
            $data['photo'] = $this->storeFile($request->file('photo'));
        }

        $employee->update($data);
        $employee->phones()->delete();
        foreach ($phones as $phone) {
            if ($phone) {
                $employee->phones()->create(['phone' => $phone]);
            }
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
