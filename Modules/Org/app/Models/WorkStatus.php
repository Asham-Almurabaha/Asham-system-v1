<?php

namespace Modules\Org\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;

class WorkStatus extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code', 'name_en', 'name_ar', 'is_active',
    ];
}

