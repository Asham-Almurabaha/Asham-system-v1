<?php

namespace Modules\Leaves\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = ['code','name','name_ar','accrual_policy'];

    protected $casts = [
        'accrual_policy' => 'array',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
