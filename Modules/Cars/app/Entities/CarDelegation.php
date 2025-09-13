<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cars\Entities\Concerns\FormatsHijriDates;
use Modules\Cars\Entities\Lookups\CarDelegationType;
use Modules\Employees\Models\Employee;

class CarDelegation extends Model
{
    use HasFactory, FormatsHijriDates;

    protected $fillable = [
        'car_id',
        'employee_id',
        'car_delegation_type_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CarDelegationType::class, 'car_delegation_type_id');
    }

    public function getStartDateHijriAttribute(): ?string
    {
        return $this->toHijri($this->start_date);
    }

    public function getEndDateHijriAttribute(): ?string
    {
        return $this->toHijri($this->end_date);
    }
}
