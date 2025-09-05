<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // أولوية: session → user->locale → config('app.locale')
        $locale = session('locale');

        if (!$locale && auth()->check() && !empty(auth()->user()->locale ?? null)) {
            $locale = auth()->user()->locale;
        }

        app()->setLocale($locale ?: config('app.locale'));

        return $next($request);
    }
}
