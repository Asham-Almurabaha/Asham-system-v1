<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cars\Entities\Concerns\FormatsHijriDates;
use Modules\Cars\Entities\Lookups\CarStatus;
use Modules\Employees\Models\Employee;

class CarAssignment extends Model
{
    use HasFactory, FormatsHijriDates;

    protected $fillable = [
        'car_id','employee_id','assigned_at','returned_at','condition_on_assign','condition_on_return','handover_form_number','assigned_by','received_by','notes'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
        'condition_on_assign' => CarCondition::class,
        'condition_on_return' => CarCondition::class,
    ];

    protected static function booted()
    {
        static::created(function ($assignment) {
            $assignment->car->update([
                'car_status_id' => CarStatus::where('name_en', 'assigned')->value('id'),
            ]);
        });
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'received_by');
    }

    public function getAssignedAtHijriAttribute(): ?string
    {
        return $this->toHijri($this->assigned_at);
    }

    public function getReturnedAtHijriAttribute(): ?string
    {
        return $this->toHijri($this->returned_at);
    }
}

enum CarCondition: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case NEEDS_MAINTENANCE = 'needs_maintenance';
    case DAMAGED = 'damaged';
}
