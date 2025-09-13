<?php

namespace Modules\Cars\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Cars\Entities\Lookups\CarDocumentDataType;

class CarDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'car_document_data_type_id',
        'name',
        'value',
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function dataType(): BelongsTo
    {
        return $this->belongsTo(CarDocumentDataType::class, 'car_document_data_type_id');
    }
}
