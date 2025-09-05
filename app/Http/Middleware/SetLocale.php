<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // أولوية: session → user->locale → config('app.locale')
        $locale = session('locale')
            ?? ($request->user()->locale ?? null)
            ?? config('app.locale');

        app()->setLocale($locale);

        return $next($request);
    }
}
