<?php

namespace Modules\Cars\Entities\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name_en', 'name_ar'];

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class, 'car_type_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(CarBrand::class, 'car_type_id');
    }
}
