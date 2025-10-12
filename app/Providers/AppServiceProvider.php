<?php

namespace App\Providers;

use Modules\Settings\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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

            if (!app()->runningInConsole() && app()->bound('session')) {
                try {
                    $session = session();

                    $customFavicon = null;

                    if (!$customFavicon && !empty($setting?->favicon_url)) {
                        $customFavicon = $setting->favicon_url;
                    }

                    if (!$customFavicon && !empty($setting?->favicon)) {
                        $customFavicon = asset('storage/' . $setting->favicon);
                    }

                    $defaultPngFavicon = asset('assets/img/favicon.png');
                    $defaultAppleIcon  = asset('assets/img/apple-touch-icon.png');

                    $faviconHref = $customFavicon ?? $defaultPngFavicon;
                    $faviconPath = parse_url($faviconHref, PHP_URL_PATH);
                    $extension   = $faviconPath ? pathinfo($faviconPath, PATHINFO_EXTENSION) : null;
                    $extension   = strtolower($extension ?? '');

                    $mimeMap = [
                        'ico'  => 'image/x-icon',
                        'png'  => 'image/png',
                        'svg'  => 'image/svg+xml',
                        'gif'  => 'image/gif',
                        'jpg'  => 'image/jpeg',
                        'jpeg' => 'image/jpeg',
                        'webp' => 'image/webp',
                    ];

                    $faviconType    = $mimeMap[$extension] ?? 'image/png';
                    $appleTouchHref = $customFavicon && in_array($extension, ['png', 'jpg', 'jpeg', 'webp'], true)
                        ? $customFavicon
                        : $defaultAppleIcon;

                    $session->put([
                        'app.locale'  => $locale,
                        'app.name'    => $appName,
                        'app.favicon' => [
                            'href'        => $faviconHref,
                            'type'        => $faviconType,
                            'apple_touch' => $appleTouchHref,
                        ],
                    ]);
                } catch (\Throwable $exception) {
                    // Ignore session exceptions (e.g. when running from CLI)
                }
            }
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

        Paginator::defaultView('layouts.pagination');
    }
}
