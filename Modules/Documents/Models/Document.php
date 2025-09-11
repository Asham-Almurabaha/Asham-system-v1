<?php

namespace Modules\Documents\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Modules\Employees\Models\Employee;

class Document extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'employee_id','type','number','issuer','issue_at','expire_at','file_path','notes',
    ];

    protected $casts = [
        'issue_at' => 'date',
        'expire_at' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function getDaysLeftAttribute(): ?int
    {
        return $this->expire_at ? Carbon::now()->diffInDays($this->expire_at, false) : null;
    }

    public function scopeExpiringWithin($query, int $days)
    {
        return $query->whereNotNull('expire_at')
            ->whereBetween('expire_at', [now(), now()->addDays($days)]);
    }
}
