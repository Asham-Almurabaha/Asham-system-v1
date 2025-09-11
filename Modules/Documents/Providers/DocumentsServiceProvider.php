<?php

namespace Modules\Documents\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class DocumentsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'documents');
        $this->loadTranslationsFrom(__DIR__.'/../lang', 'documents');
        if ($this->app->runningInConsole()) {
            $this->commands([
                \Modules\Documents\Console\CheckDocumentExpiry::class,
            ]);
        }
    }
}
