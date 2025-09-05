<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(
        string $event,
        object|string|null $subject = null,
        ?string $description = null,
        array $properties = [],
        ?int $status = null,
        ?string $operationType = null,
        ?array $before = null,
        ?array $after = null,
    ): void {
        // Avoid recursion when logging ActivityLog itself
        if ($subject instanceof ActivityLog) {
            return;
        }

        $causer = Auth::user();

        $subjectType = null;
        $subjectId   = null;

        if ($subject instanceof Model) {
            $subjectType = get_class($subject);
            $subjectId   = $subject->getKey();
        } elseif (is_string($subject)) {
            $subjectType = $subject;
        } elseif (is_object($subject)) {
            $subjectType = get_class($subject);
        }

        $req = request();
        $ip = null; $ua = null; $method = null; $url = null; $route = null; $statusCode = $status;
        try {
            if ($req) {
                $ip     = $req->ip();
                $ua     = $req->userAgent();
                $method = $req->method();
                $url    = $req->fullUrl();
                $route  = optional($req->route())->getName() ?? optional($req->route())->uri();
                $statusCode = $statusCode ?? (function () { try { return response()->getStatusCode(); } catch (\Throwable) { return null; } })();
            }
        } catch (\Throwable) {
            // ignore request context errors
        }

        // basic sensitive keys filter
        $filterKeys = ['password', 'password_confirmation', 'current_password', 'token'];
        if (!empty($properties)) {
            $properties = self::maskSensitive($properties, $filterKeys);
        }
        if (!empty($before)) {
            $before = self::maskSensitive($before, $filterKeys);
        }
        if (!empty($after)) {
            $after = self::maskSensitive($after, $filterKeys);
        }

        ActivityLog::query()->create([
            'event'        => $event,
            'operation_type' => $operationType ?? $event,
            'description'  => $description,
            'subject_type' => $subjectType,
            'subject_id'   => $subjectId,
            'causer_id'    => $causer?->getAuthIdentifier(),
            'causer_type'  => $causer ? get_class($causer) : null,
            'properties'   => $properties ?: null,
            'value_before' => $before ?: null,
            'value_after'  => $after ?: null,
            'ip'           => $ip,
            'user_agent'   => $ua,
            'method'       => $method,
            'url'          => $url,
            'route'        => $route,
            'status'       => $statusCode,
        ]);
    }

    private static function maskSensitive(array $data, array $keys): array
    {
        $lowerKeys = array_map('strtolower', $keys);
        $masked = [];
        foreach ($data as $k => $v) {
            $lk = strtolower((string)$k);
            if (in_array($lk, $lowerKeys, true)) {
                $masked[$k] = '***';
            } elseif (is_array($v)) {
                $masked[$k] = self::maskSensitive($v, $keys);
            } else {
                $masked[$k] = $v;
            }
        }
        return $masked;
    }
}
