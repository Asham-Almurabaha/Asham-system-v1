<?php

namespace Modules\Assets\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Employees\Models\Employee;
use Modules\Org\Models\Branch;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = ['branch_id','type','serial','description','cost','status'];

    protected $casts = [
        'cost' => 'float',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignments()
    {
        return $this->hasMany(AssetAssignment::class);
    }
}
