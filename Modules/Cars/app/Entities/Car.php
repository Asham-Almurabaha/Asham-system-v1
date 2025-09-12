<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Cars\Entities\CarAssignment;
use Modules\Org\Models\Branch;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number','vin','year','brand','model','color','status','purchase_date','cost','branch_id','notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'year' => 'integer',
        'cost' => 'decimal:2',
        'status' => CarStatus::class,
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(CarAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(CarAssignment::class)->whereNull('returned_at');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', CarStatus::AVAILABLE);
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', CarStatus::ASSIGNED);
    }
}

enum CarStatus: string
{
    case AVAILABLE = 'available';
    case ASSIGNED = 'assigned';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';
}
