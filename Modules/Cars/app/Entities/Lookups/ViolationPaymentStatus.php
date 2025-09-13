<?php

namespace Modules\Cars\Entities\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViolationPaymentStatus extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name_en', 'name_ar'];
}
