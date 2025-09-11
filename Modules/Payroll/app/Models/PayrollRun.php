<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payroll\Models\PayrollItem;
use Modules\Payroll\Models\WpsFile;
use Modules\Org\Models\Company;

class PayrollRun extends Model
{
    use HasFactory;

    protected $fillable = ['company_id','month','status','posted_at'];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function items()
    {
        return $this->hasMany(PayrollItem::class);
    }

    public function wpsFiles()
    {
        return $this->hasMany(WpsFile::class);
    }
}
