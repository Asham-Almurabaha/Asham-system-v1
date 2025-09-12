<?php

namespace Modules\Org\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Org\Models\Branch;
use Modules\Org\Models\Department;
use Modules\Org\Models\Title;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name_en', 'name_ar', 'cr_number', 'vat_number', 'iban',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function titles(): HasMany
    {
        return $this->hasMany(Title::class);
    }
}
