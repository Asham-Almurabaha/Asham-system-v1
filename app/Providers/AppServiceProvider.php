<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        // Share a safe $setting instance and computed $appName with all views
        View::composer('*', function ($view) {
            $setting = null;

            try {
                if (Schema::hasTable('settings')) {
                    $setting = Cache::remember('app.settings.row', 3600, fn () => Setting::query()->first());
                }
            } catch (\Throwable $e) {
                $setting = null;
            }

            // Always provide an object to avoid property access errors in views
            $setting = $setting ?? new Setting();

            $locale   = app()->getLocale();
            $fallback = config('app.name', '');

            $appName = $locale === 'ar'
                ? ($setting->name_ar ?? $setting->name ?? $fallback)
                : ($setting->name ?? $setting->name_ar ?? $fallback);

            $view->with('setting', $setting);
            $view->with('appName', $appName);
        });

        // Clear cache when settings change
        Setting::saved(fn () => Cache::forget('app.settings.row'));
        Setting::deleted(fn () => Cache::forget('app.settings.row'));

        // Optionally provide $settings for selected views, guarded by schema existence
        View::composer(['welcome', 'layouts.*'], function ($view) {
            $settings = null;

            try {
                if (Schema::hasTable('settings')) {
                    $settings = Setting::query()->first();
                }
            } catch (\Throwable $e) {
                $settings = null;
            }

            $view->with('settings', $settings);
        });

    }
}
