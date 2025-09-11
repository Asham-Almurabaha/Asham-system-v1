<?php

namespace Modules\Contracts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Employees\Models\Employee;

class Contract extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id', 'start_at', 'end_at', 'probation_end_at', 'type',
        'housing_allowance', 'transport_allowance', 'other_allowances',
        'status', 'attachment_path', 'notes',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
        'probation_end_at' => 'date',
        'other_allowances' => 'array',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
