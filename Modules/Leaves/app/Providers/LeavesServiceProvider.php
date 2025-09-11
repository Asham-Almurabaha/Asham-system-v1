<?php

namespace Modules\Leaves\Providers;

use Illuminate\Support\ServiceProvider;

class LeavesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    public function register(): void
    {
        //
    }
}
