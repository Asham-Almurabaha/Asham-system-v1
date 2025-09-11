<?php

namespace Modules\Leaves\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Employees\Models\Employee;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','leave_type_id','start_at','end_at','days','status','approver_id','reason'];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
        'days' => 'float',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
