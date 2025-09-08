<?php

namespace Modules\Titles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Departments\Models\Department;

class Title extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'name_ar', 'is_active', 'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
