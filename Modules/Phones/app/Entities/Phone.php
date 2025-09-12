<?php

namespace Modules\Phones\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'imei','serial_number','brand','model','color','line_number','status','purchase_date','cost','branch_id','notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'cost' => 'decimal:2',
        'status' => PhoneStatus::class,
    ];

    public function assignments(): HasMany
    {
        return $this->hasMany(PhoneAssignment::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(PhoneAssignment::class)->whereNull('returned_at');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', PhoneStatus::AVAILABLE);
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', PhoneStatus::ASSIGNED);
    }
}

enum PhoneStatus: string
{
    case AVAILABLE = 'available';
    case ASSIGNED = 'assigned';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';
}
