<?php

namespace Modules\Employees\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Modules\Settings\Models\Setting;

class EmployeesServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Employees';

    protected string $nameLower = 'employees';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->shareFaviconWithViews();
        $this->loadMigrationsFrom(module_path($this->name, 'database/migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = module_path($this->name, 'lang');

        $this->loadTranslationsFrom($langPath, $this->nameLower);
        $this->loadJsonTranslationsFrom($langPath);

        foreach (['en', 'ar'] as $locale) {
            $file = $langPath.'/'.$locale.'/employees.php';
            if (file_exists($file)) {
                $lines = require $file;

                $namespaced = [];
                foreach ($lines as $key => $value) {
                    $namespaced['employees.'.$key] = $value;
                }

                Lang::addLines($namespaced, $locale, $this->nameLower);
            }
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower.'.'.$config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace').'\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->nameLower)) {
                $paths[] = $path.'/modules/'.$this->nameLower;
            }
        }

        return $paths;
    }

    protected function shareFaviconWithViews(): void
    {
        View::composer($this->nameLower.'::*', function ($view) {
            $viewData = $view->getData();
            $sharedData = View::getShared();

            $settingFromView = $viewData['setting'] ?? null;
            $settingFromShared = $sharedData['setting'] ?? null;

            $setting = $settingFromView ?? $settingFromShared;

            if (!$setting) {
                try {
                    if (Schema::hasTable('settings')) {
                        $setting = Cache::remember('app.settings.row', 3600, fn () => Setting::query()->first());
                    }
                } catch (\Throwable $exception) {
                    $setting = null;
                }
            }

            $sessionFavicon = null;

            if (!app()->runningInConsole() && app()->bound('session')) {
                try {
                    $sessionFavicon = data_get(session('app.favicon'), 'href');
                } catch (\Throwable $exception) {
                    $sessionFavicon = null;
                }
            }

            $customFavicon = $sessionFavicon;

            if (!$customFavicon && $setting) {
                if (!empty($setting->favicon_url)) {
                    $customFavicon = $setting->favicon_url;
                } elseif (!empty($setting->favicon)) {
                    $customFavicon = asset('storage/'.$setting->favicon);
                }
            }

            $faviconHref = $customFavicon ?? asset('assets/img/favicon.png');

            $view->with('favicon', $faviconHref);
        });
    }
}
