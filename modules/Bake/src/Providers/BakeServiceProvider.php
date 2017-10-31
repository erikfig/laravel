<?php

namespace ErikFig\BakeModules\Providers;

use Illuminate\Support\ServiceProvider;
use ErikFig\BakeModules\Console\Commands\BakeCommand;

class BakeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BakeCommand::class
            ]);
        }

        $this->publishes([
            __DIR__.'/../config/modules.php' => config_path('modules.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/modules.php',
            'modules'
        );
    }
}
