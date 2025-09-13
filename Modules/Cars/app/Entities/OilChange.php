<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OilChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'changed_at',
        'mileage',
        'notes',
    ];

    protected $casts = [
        'changed_at' => 'date',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
