<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Employees\Models\Employee;

class EmploymentStatus extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name_en', 'name_ar', 'is_active',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'employment_status_id');
    }
}
