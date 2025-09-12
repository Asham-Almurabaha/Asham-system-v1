<?php

namespace Modules\Motorcycles\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Motorcycles\Entities\Concerns\FormatsHijriDates;
use Modules\Employees\Models\Employee;

class MotorcycleAssignment extends Model
{
    use HasFactory, FormatsHijriDates;

    protected $fillable = [
        'motorcycle_id','employee_id','assigned_at','returned_at','condition_on_assign','condition_on_return','handover_form_number','assigned_by','received_by','notes'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
        'condition_on_assign' => MotorcycleCondition::class,
        'condition_on_return' => MotorcycleCondition::class,
    ];

    public function motorcycle(): BelongsTo
    {
        return $this->belongsTo(Motorcycle::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
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

enum MotorcycleCondition: string
{
    case EXCELLENT = 'excellent';
    case GOOD = 'good';
    case NEEDS_MAINTENANCE = 'needs_maintenance';
    case DAMAGED = 'damaged';
}
