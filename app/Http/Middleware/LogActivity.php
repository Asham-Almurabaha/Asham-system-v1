<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogger;
use Closure;
use Illuminate\Http\Request;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log state-changing requests or auth actions
        $method = strtoupper($request->method());
        $shouldLog = !in_array($method, ['GET', 'HEAD', 'OPTIONS'], true);

        // Also log login/logout explicitly by route names if present
        $routeName = optional($request->route())->getName();
        if (in_array($routeName, ['login', 'logout'], true)) {
            $shouldLog = true;
        }

        if ($shouldLog) {
            $payload = $request->except(['password', 'password_confirmation', 'current_password', '_token']);
            ActivityLogger::log(
                event: 'request',
                subject: 'http',
                description: sprintf('%s %s', $method, $request->path()),
                properties: [
                    'input' => $payload,
                    'route' => $routeName,
                ],
                status: method_exists($response, 'getStatusCode') ? $response->getStatusCode() : null,
                operationType: strtolower($method),
            );
        }

        return $response;
    }
}

