<?php

namespace Modules\Org\Providers;

use Illuminate\Support\ServiceProvider;

class OrgServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'org');
    }
}
