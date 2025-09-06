<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use DateTimeInterface;

trait LogsActivity
{
    public static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            AuditLog::create([
                'table_name' => $model->getTable(),
                'record_id' => $model->getKey(),
                'action' => 'INSERT',
                'old_values' => null,
                'new_values' => self::serializeAttributes($model->getAttributes()),
                'performed_by' => Auth::id(),
                'performed_at' => now(),
            ]);
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            $oldValues = self::serializeAttributes(array_intersect_key($model->getOriginal(), $changes));
            $newValues = self::serializeAttributes(array_intersect_key($model->getAttributes(), $changes));

            AuditLog::create([
                'table_name' => $model->getTable(),
                'record_id' => $model->getKey(),
                'action' => 'UPDATE',
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'performed_by' => Auth::id(),
                'performed_at' => now(),
            ]);
        });

        static::deleted(function ($model) {
            AuditLog::create([
                'table_name' => $model->getTable(),
                'record_id' => $model->getKey(),
                'action' => 'DELETE',
                'old_values' => self::serializeAttributes($model->getOriginal()),
                'new_values' => null,
                'performed_by' => Auth::id(),
                'performed_at' => now(),
            ]);
        });
    }

    protected static function serializeAttributes(array $attributes): array
    {
        foreach ($attributes as $key => $value) {
            if ($value instanceof DateTimeInterface) {
                $attributes[$key] = $value->format('Y-m-d H:i:s');
            }
        }

        return $attributes;
    }
}
