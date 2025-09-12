<?php

namespace Modules\Contracts\Providers;

use Illuminate\Support\ServiceProvider;

class ContractsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'contracts');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'contracts');
    }

    public function register(): void
    {
        //
    }
}
