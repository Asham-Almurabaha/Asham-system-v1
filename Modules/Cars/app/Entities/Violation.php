<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cars\Entities\Lookups\{ViolationType, ViolationPaymentStatus};
use Modules\Employees\Models\Employee;

class Violation extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'employee_id',
        'violation_type_id',
        'violation_payment_status_id',
        'violation_date',
        'amount',
        'description',
    ];

    protected $casts = [
        'violation_date' => 'date',
        'amount' => 'decimal:2',
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
        return $this->belongsTo(ViolationType::class, 'violation_type_id');
    }

    public function paymentStatus(): BelongsTo
    {
        return $this->belongsTo(ViolationPaymentStatus::class, 'violation_payment_status_id');
    }
}
