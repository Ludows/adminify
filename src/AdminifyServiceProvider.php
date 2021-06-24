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

        $app = app();

        if(!$app->runningInConsole()) {
            $packages = require_once(__DIR__.'/../config/packagelist.php');
            
            $this->bootableDependencies($packages);
        }
        if($app->runningInConsole()) {
            $this->publishes(array(
                __DIR__.'/../config/check-permissions.php' => config_path('check-permissions.php'),
                __DIR__.'/../config/site-settings.php' => config_path('site-settings.php'),
            ), 'adminify-config');
        }
       

        // 'MyMenuBuilder' => App\Helpers\MenuBuilderFacade::class,

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

    private function bootableDependencies($packages) {

        foreach ($packages as $dependency) {
            # code...
            // first of all register Providers
            if(count($dependency->autoload->providers) > 0) {
                $providers = $dependency->autoload->providers;

                foreach ($providers as $provider) {
                    # code...
                    $this->app->register($provider);
                }
            }

            // Second one register Middlewares

            //$this->app['router']->aliasMiddleware('shortname', Vendor\Some\Class::class);

            // and finaly register Aliases

        }
        

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