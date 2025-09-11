<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Employees\Models\Employee;

class OvertimeRequest extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id','date','minutes','status','approver_id'];

    protected $casts = [
        'date' => 'date',
        'minutes' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
