<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;
use Modules\Org\Models\Job;
use Modules\Org\Models\Nationality;
use Modules\Employees\Models\EmployeePhone;
use Modules\Employees\Models\EmployeeResidency;
use Illuminate\Support\Facades\Storage;

class Employee extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'first_name', 'first_name_ar', 'last_name', 'last_name_ar', 'email', 'photo', 'hire_date',
        'branch_id', 'department_id', 'job_id', 'nationality_id', 'is_active',
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

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
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

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::url($this->photo) : null;
    }
}
