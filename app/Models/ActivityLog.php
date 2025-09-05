<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $table = 'activity_logs';

    protected $fillable = [
        'event',
        'operation_type',
        'description',
        'subject_type',
        'subject_id',
        'causer_id',
        'causer_type',
        'properties',
        'value_before',
        'value_after',
        'ip',
        'user_agent',
        'method',
        'url',
        'route',
        'status',
    ];

    protected $casts = [
        'properties' => 'array',
        'value_before' => 'array',
        'value_after'  => 'array',
    ];

    public function getChangesAttribute(): array
    {
        $before = $this->value_before ?? [];
        $after  = $this->value_after ?? [];

        $keys = array_unique(array_merge(array_keys((array) $before), array_keys((array) $after)));
        $changes = [];
        foreach ($keys as $key) {
            $from = $before[$key] ?? null;
            $to   = $after[$key] ?? null;
            if ($from !== $to) {
                $changes[$key] = ['from' => $from, 'to' => $to];
            }
        }

        return $changes;
    }

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}

