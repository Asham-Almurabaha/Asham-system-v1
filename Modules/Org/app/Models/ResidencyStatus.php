<?php

namespace Modules\Org\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;

class ResidencyStatus extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name_en', 'name_ar', 'is_active',
    ];
}

