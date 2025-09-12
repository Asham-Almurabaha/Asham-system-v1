<?php

namespace Modules\Motorcycles\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Org\Models\Branch;

class Motorcycle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate_number','chassis_number','year','brand','model','color','status','purchase_date','cost','branch_id','notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'year' => 'integer',
        'cost' => 'decimal:2',
        'status' => MotorcycleStatus::class,
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(MotorcycleAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(MotorcycleAssignment::class)->whereNull('returned_at');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', MotorcycleStatus::AVAILABLE);
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', MotorcycleStatus::ASSIGNED);
    }
}

enum MotorcycleStatus: string
{
    case AVAILABLE = 'available';
    case ASSIGNED = 'assigned';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';
}
