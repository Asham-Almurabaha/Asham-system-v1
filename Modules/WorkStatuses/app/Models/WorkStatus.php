<?php

namespace Modules\WorkStatuses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;

class WorkStatus extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'name_ar', 'is_active',
    ];
}

