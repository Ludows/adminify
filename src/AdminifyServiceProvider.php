<?php

namespace Ludows\Adminify;

use Illuminate\Support\ServiceProvider;

use Ludows\Adminify\Commands\TraitGenerator;
use Ludows\Adminify\Commands\RouteList;
use Ludows\Adminify\Commands\createTranslations;
use Ludows\Adminify\Commands\InstallPackages;

use Ludows\Adminify\View\Components\Modal;

class AdminifyServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot() {

        $packages = require_once(__DIR__.'/../config/packagelist.php');

        //dd($packages);

        // Publishing is only necessary when using the CLI.
        // if ($this->app->runningInConsole()) {

        //     $this->bootForConsole();
        // }

        // $this->app->register(
        //     MyProvider::class
        // );

        $this->mergeConfigFrom(
            __DIR__.'/../config/site-settings.php', 'adminify'
        );
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminify');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminify');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {

        // Register the service the package provides.

        $this->app->singleton('adminify', function($app) {

            return new Adminify;
        });

        $this->loadViewComponentsAs('adminify', [
            Modal::class,
        ]);

        $this->registerCommands();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {

        return ['adminify'];
    }

    private function registerCommands() {
        
        $this->commands([
            InstallPackages::class,
            TraitGenerator::class,
            RouteList::class,
            createTranslations::class
        ]);
    }
}