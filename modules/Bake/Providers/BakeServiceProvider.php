<?php

namespace Modules\Bake\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Bake\Console\Commands\BakeCommand;

class BakeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                BakeCommand::class
            ]);
        }
    }
}
