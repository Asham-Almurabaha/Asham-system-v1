<?php

namespace Modules\Phones\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Phones\Entities\Concerns\FormatsHijriDates;
use Modules\Employees\Models\Employee;

class PhoneAssignment extends Model
{
    use HasFactory, FormatsHijriDates;

    protected $fillable = [
        'phone_id','employee_id','assigned_at','returned_at','condition_on_assign','condition_on_return','handover_form_number','assigned_by','received_by','notes'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'returned_at' => 'datetime',
        'condition_on_assign' => PhoneCondition::class,
        'condition_on_return' => PhoneCondition::class,
    ];

    public function phone(): BelongsTo
    {
        return $this->belongsTo(Phone::class);
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

enum PhoneCondition: string
{
    case NEW = 'new';
    case GOOD = 'good';
    case USED = 'used';
    case DAMAGED = 'damaged';
}
