<?php

namespace CodeLab\LicenseSystem;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use CodeLab\LicenseSystem\Http\Middleware\CheckLicense;

class LicenseServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load Routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Load Views
        $this->loadViewsFrom(__DIR__.'/resources/views', 'license-system');

        // Publish Config
        $this->publishes([
            __DIR__.'/config/license.php' => config_path('license.php'),
        ], 'license-config');

        // Publish Views
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/license-system'),
        ], 'license-views');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/license.php', 'license'
        );
    }
}
