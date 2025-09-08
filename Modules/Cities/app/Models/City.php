<?php

namespace Modules\Cities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Branches\Models\Branch;

class City extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'name_ar', 'is_active',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }
}

