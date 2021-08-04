<?php

namespace Ludows\Adminify;

use Illuminate\Support\ServiceProvider;

use Ludows\Adminify\Commands\TraitGenerator;
use Ludows\Adminify\Commands\RouteList;
use Ludows\Adminify\Commands\createTranslations;
use Ludows\Adminify\Commands\InstallPackages;
use Ludows\Adminify\Commands\generateFeeds;

use Illuminate\Contracts\Http\Kernel; // add kernel

use Ludows\Adminify\View\Components\Modal;

class AdminifyServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Kernel $kernel) {

        $app = app();

        if(!$app->runningInConsole()) {
            $packages = require_once(__DIR__.'/../config/packagelist.php');

            $this->bootableDependencies($packages, $kernel);
        }
        if($app->runningInConsole()) {
            $this->publishes(array(
                __DIR__.'/../resources/views/' => resource_path('views/vendor/adminify/'),
            ), 'adminify-views');
            
            $this->publishes(array(
                __DIR__.'/../database/views/' => database_path('migrations'),
            ), 'adminify-migrations');
        }

        $config = config('site-settings.restApi');

        $this->routes(function () use ($config) {

            if($config['enable']) {

                $routerBasicApi = Route::middleware('web');
                if($config['prefix'] != null) {
                    $routerBasicApi->prefix($config['prefix']);
                }
                if($config['domain'] != null) {
                    $routerBasicApi->domain($config['domain']);
                }
                $routerBasicApi->namespace($this->namespace)
                ->group(base_path('vendor/ludows/adminify/routes/api.php'));
            }

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('vendor/ludows/adminify/routes/web.php'));

        });


        $this->mergeConfigFrom(
            __DIR__.'/../config/site-settings.php', 'adminify'
        );
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminify');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminify');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        //$this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // $this->mergeConfigFrom(__DIR__.'/../config/api.php', 'api');

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

    private function bootableDependencies($packages, $kernel) {

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

            if(count($dependency->autoload->middlewares) > 0) {
                $middlewares = $dependency->autoload->middlewares;
                $router = $this->app['router'];

                if( array_key_exists('named', $middlewares) ) {
                    $keys = array_keys($middlewares['named']);

                    foreach ($keys as $key) {
                        # code...
                        $router->aliasMiddleware($key, $middlewares['named'][$key]);
                    }
                }

                if( array_key_exists('web', $middlewares) ) {
                    // $router->pushMiddlewareToGroup('web', MyMiddleware::class);
                    foreach ($middlewares['web'] as $middleware) {
                        # code...
                        $router->pushMiddlewareToGroup('web', $middleware);
                    }
                }

                if( array_key_exists('api', $middlewares) ) {
                    // $router->pushMiddlewareToGroup('web', MyMiddleware::class);
                    foreach ($middlewares['api'] as $middleware) {
                        # code...
                        $router->pushMiddlewareToGroup('api', $middleware);
                    }
                }

                if( array_key_exists('global', $middlewares) ) {
                    foreach ($middlewares['global'] as $middleware) {
                        # code...
                        // $router->middleware($middleware);
                        $kernel->pushMiddleware($middleware);
                    }
                }

            }

            // and finaly register Aliases

            if(count($dependency->autoload->aliases) > 0) {
                /*
                * Create aliases for the dependency.
                */
                $loader = \Illuminate\Foundation\AliasLoader::getInstance();
                $aliases = $dependency->autoload->aliases;
                $keys = array_keys($aliases);
                foreach ($keys as $key) {
                    # code...
                    $loader->alias($key, $aliases[$key]);
                }

            }

        }
        

    }

    private function registerCommands() {
        
        $this->commands([
            generateFeeds::class,
            InstallPackages::class,
            TraitGenerator::class,
            RouteList::class,
            createTranslations::class,
        ]);
    }
}