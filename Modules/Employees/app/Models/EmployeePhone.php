<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePhone extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'phone'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
