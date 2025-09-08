<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Branches\Models\Branch;
use Modules\Departments\Models\Department;
use Modules\Titles\Models\Title;
use Modules\Nationalities\Models\Nationality;
use Modules\Employees\Models\EmployeePhone;
use Modules\Employees\Models\EmployeeResidency;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'first_name', 'first_name_ar', 'last_name', 'last_name_ar', 'email', 'hire_date',
        'branch_id', 'department_id', 'title_id', 'nationality_id', 'is_active',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
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
}
