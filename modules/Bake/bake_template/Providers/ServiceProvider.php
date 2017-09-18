<?php

namespace Modules\{{plural-upper}}\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class {{singular-upper}}ServiceProvider extends ServiceProvider
{
    protected $namespace = 'Modules\{{plural-upper}}\Controllers';
    
    public function boot()
    {
        $this->webRoutes();
        $this->apiRoutes();

        $this->loadViewsFrom(__DIR__ . '/../Views', '{{singular-upper}}');
    }

    
    public function register()
    {
        //
    }

    protected function webRoutes()
    {
        if (!$this->app->routesAreCached()) {
            Route::namespace($this->namespace)
                ->group(__DIR__ . '/../Routes/web.php');
        }
    }

    protected function apiRoutes()
    {        
        if (!$this->app->routesAreCached()) {
            Route::prefix('api')
                ->namespace($this->namespace)
                ->group(__DIR__ . '/../Routes/api.php');
        }
    }
}
