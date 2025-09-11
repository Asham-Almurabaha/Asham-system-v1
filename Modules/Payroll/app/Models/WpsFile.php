<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WpsFile extends Model
{
    use HasFactory;

    protected $fillable = ['payroll_run_id','file_path','meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function run()
    {
        return $this->belongsTo(PayrollRun::class, 'payroll_run_id');
    }
}
