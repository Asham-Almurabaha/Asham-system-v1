<?php

namespace Modules\Employees\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeResidency extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'absher_id_image',
        'tawakkalna_id_image',
        'expiry_date',
        'employer_name',
        'employer_id',
        'is_active',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (EmployeeResidency $residency) {
            // deactivate previous residencies of the same employee
            static::where('employee_id', $residency->employee_id)->update(['is_active' => false]);
            $residency->is_active = true;
        });
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
