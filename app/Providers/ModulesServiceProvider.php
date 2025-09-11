<?php

namespace App\Providers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->booting(fn () => $this->registerModuleProviders());
    }

    protected function registerModuleProviders(): void
    {
        $fs = new Filesystem();
        $modulesPath = base_path('Modules');
        if (! $fs->isDirectory($modulesPath)) {
            return;
        }

        foreach ($fs->directories($modulesPath) as $module) {
            $providerPath = $module.'/app/Providers';
            if (! $fs->isDirectory($providerPath)) {
                continue;
            }

            foreach ($fs->files($providerPath) as $file) {
                if ($file->getExtension() !== 'php') {
                    continue;
                }

                $class = sprintf(
                    'Modules\\%s\\Providers\\%s',
                    $fs->basename($module),
                    $file->getFilenameWithoutExtension()
                );

                if (class_exists($class)) {
                    $this->app->register($class);
                }
            }
        }
    }
}
