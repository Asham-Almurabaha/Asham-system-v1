<?php

namespace Modules\Org\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\AuditLogs\Traits\LogsActivity;
use Modules\Cities\Models\City;
use App\Models\User;

class Branch extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name_en', 'name_ar', 'is_active', 'company_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
