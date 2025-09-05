<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;
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

        // Global model activity logging (create/update/delete)
        Model::created(function (Model $model) {
            if ($model instanceof ActivityLog) { return; }
            $props  = self::extractModelProps($model, 'created');
            $before = null;
            $after  = $props['attributes'] ?? null;
            ActivityLogger::log('created', $model, description: class_basename($model).' created', properties: $props, operationType: 'created', before: $before, after: $after);
        });

        Model::updated(function (Model $model) {
            if ($model instanceof ActivityLog) { return; }
            $props  = self::extractModelProps($model, 'updated');
            $before = $props['original'] ?? null;
            $after  = $props['attributes'] ?? null;
            ActivityLogger::log('updated', $model, description: class_basename($model).' updated', properties: $props, operationType: 'updated', before: $before, after: $after);
        });

        Model::deleted(function (Model $model) {
            if ($model instanceof ActivityLog) { return; }
            $props  = self::extractModelProps($model, 'deleted');
            $before = $props['attributes'] ?? null;
            ActivityLogger::log('deleted', $model, description: class_basename($model).' deleted', properties: $props, operationType: 'deleted', before: $before);
        });
    }

    protected static function extractModelProps(Model $model, string $type): array
    {
        // mask hidden or sensitive attributes
        $hidden = array_map('strtolower', $model->getHidden());

        $filter = function (array $arr) use ($hidden): array {
            $out = [];
            foreach ($arr as $k => $v) {
                if (in_array(strtolower((string)$k), array_merge($hidden, ['password','remember_token']), true)) {
                    $out[$k] = '***';
                } else {
                    $out[$k] = $v;
                }
            }
            return $out;
        };

        if ($type === 'updated') {
            return [
                'changes'    => $filter($model->getChanges()),
                'attributes' => $filter($model->getAttributes()),
                'original'   => $filter($model->getOriginal()),
            ];
        }

        return [
            'attributes' => $filter($model->getAttributes()),
        ];
    }
}
