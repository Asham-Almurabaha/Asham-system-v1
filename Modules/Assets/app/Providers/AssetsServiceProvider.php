<?php

namespace Modules\Assets\Providers;

use Illuminate\Support\ServiceProvider;

class AssetsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'assets');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'assets');
    }

    public function register(): void
    {
        //
    }
}
