<?php

namespace Modules\Cars\Entities\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cars\Entities\CarDelegation;

class CarDelegationType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name_en', 'name_ar'];

    public function delegations(): HasMany
    {
        return $this->hasMany(CarDelegation::class, 'car_delegation_type_id');
    }
}
