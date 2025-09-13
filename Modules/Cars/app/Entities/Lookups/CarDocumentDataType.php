<?php

namespace Modules\Cars\Entities\Lookups;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Cars\Entities\CarDocument;

class CarDocumentDataType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name_en', 'name_ar'];

    public function documents(): HasMany
    {
        return $this->hasMany(CarDocument::class, 'car_document_data_type_id');
    }
}
