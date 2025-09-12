<?php

namespace Modules\Org\Providers;

use Illuminate\Support\ServiceProvider;

class OrgServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'org');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'org');
    }

    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
