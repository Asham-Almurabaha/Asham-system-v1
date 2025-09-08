<?php

namespace Modules\Departments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Titles\Models\Title;

class Department extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'name_ar', 'is_active',
    ];

    public function titles()
    {
        return $this->hasMany(Title::class);
    }
}
