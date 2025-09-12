<?php

namespace Modules\Payroll\Providers;

use Illuminate\Support\ServiceProvider;

class PayrollServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'payroll');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'payroll');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../Config/wps.php', 'wps');
    }
}
