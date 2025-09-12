<?php

namespace Modules\Cars\Entities\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarBrand extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['car_type_id', 'name_en', 'name_ar'];

    public function type(): BelongsTo
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class, 'car_brand_id');
    }
}
