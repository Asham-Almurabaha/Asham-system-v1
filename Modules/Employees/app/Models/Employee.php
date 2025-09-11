<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;
use Modules\Org\Models\Title;
use Modules\Nationalities\Models\Nationality;
use Modules\Employees\Models\EmployeePhone;
use Modules\Employees\Models\EmployeeResidency;
use Illuminate\Support\Facades\Storage;
use Modules\Org\Models\Company;
use Modules\Documents\Models\Document;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code', 'first_name', 'first_name_ar', 'last_name', 'last_name_ar', 'email', 'photo', 'hire_date',
        'branch_id', 'department_id', 'title_id', 'nationality_id', 'company_id', 'manager_id',
        'national_id', 'nationality', 'dob', 'salary_basic', 'currency',
        'employment_status_id', 'work_status_id', 'sponsorship_status_id', 'is_active',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'dob' => 'date',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function manager()
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function phones()
    {
        return $this->hasMany(EmployeePhone::class);
    }

    public function residencies()
    {
        return $this->hasMany(EmployeeResidency::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function contracts()
    {
        return $this->hasMany(\Modules\Contracts\Models\Contract::class);
    }

    public function attendance()
    {
        return $this->hasMany(\Modules\Attendance\Models\Attendance::class);
    }

    public function overtimeRequests()
    {
        return $this->hasMany(\Modules\Attendance\Models\OvertimeRequest::class);
    }

    public function leaves()
    {
        return $this->hasMany(\Modules\Leaves\Models\Leave::class);
    }

    public function payrollItems()
    {
        return $this->hasMany(\Modules\Payroll\Models\PayrollItem::class);
    }

    public function assetAssignments()
    {
        return $this->hasMany(\Modules\Assets\Models\AssetAssignment::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }
}
