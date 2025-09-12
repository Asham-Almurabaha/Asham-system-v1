<?php

namespace Modules\Attendance\Providers;

use Illuminate\Support\ServiceProvider;

class AttendanceServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'attendance');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'attendance');
    }

    public function register(): void
    {
        //
    }
}
