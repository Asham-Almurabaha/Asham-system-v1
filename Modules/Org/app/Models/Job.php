<?php

namespace Modules\Org\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;

class Job extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jobs';

    protected $fillable = [
        'name_en', 'name_ar', 'is_active', 'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relationships to company and branch removed
}
