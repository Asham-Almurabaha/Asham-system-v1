<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

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

