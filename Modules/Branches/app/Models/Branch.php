<?php

namespace Modules\Branches\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use Modules\Cities\Models\City;
use App\Models\User;

class Branch extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'name_ar', 'city_id', 'is_active',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

