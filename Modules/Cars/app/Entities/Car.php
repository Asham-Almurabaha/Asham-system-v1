<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Cars\Entities\{CarAssignment, CarDocument};
use Modules\Cars\Entities\Lookups\{CarBrand, CarColor, CarModel, CarStatus, CarType, CarYear};
use Modules\Cars\Entities\OilChange;
use Modules\Cars\Entities\Violation;
use Modules\Org\Models\Branch;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'sequence_number',
        'plate_letters',
        'plate_numbers',
        'vin',
        'car_year_id',
        'car_type_id',
        'car_brand_id',
        'car_model_id',
        'car_color_id',
        'car_status_id',
        'branch_id',
        'purchase_date',
        'cost',
        'notes'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'cost' => 'decimal:2',
    ];

    public function getPlateNumberAttribute(): string
    {
        return $this->plate_letters.$this->plate_numbers;
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(CarAssignment::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(CarDocument::class);
    }

    public function currentAssignment(): HasOne
    {
        return $this->hasOne(CarAssignment::class)->whereNull('returned_at');
    }

    public function oilChanges(): HasMany
    {
        return $this->hasMany(OilChange::class);
    }

    public function violations(): HasMany
    {
        return $this->hasMany(Violation::class);
    }

    public function year(): BelongsTo
    {
        return $this->belongsTo(CarYear::class, 'car_year_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(CarType::class, 'car_type_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'car_brand_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'car_model_id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(CarColor::class, 'car_color_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CarStatus::class, 'car_status_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function scopeAvailable($query)
    {
        $statusId = CarStatus::where('name_en', 'available')->value('id');
        return $query->where('car_status_id', $statusId);
    }

    public function scopeAssigned($query)
    {
        $statusId = CarStatus::where('name_en', 'assigned')->value('id');
        return $query->where('car_status_id', $statusId);
    }
}
