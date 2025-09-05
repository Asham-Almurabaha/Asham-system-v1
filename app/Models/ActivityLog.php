<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'event',
        'description',
        'subject_type',
        'subject_id',
        'causer_id',
        'causer_type',
        'properties',
        'ip',
        'user_agent',
        'method',
        'url',
        'route',
        'status',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}

