<?php

namespace Ludows\Adminify;

use Illuminate\Support\ServiceProvider;

use Ludows\Adminify\Commands\RouteList;
use Ludows\Adminify\Commands\CreateTranslations;
use Ludows\Adminify\Commands\InstallPackages;
use Ludows\Adminify\Commands\GenerateFeeds;
use Ludows\Adminify\Commands\CreateUser;
use Ludows\Adminify\Commands\CreateModel;
use Ludows\Adminify\Commands\CreateController;
use Ludows\Adminify\Commands\CreateRepository;
use Ludows\Adminify\Commands\DoInstallEnv;
use Ludows\Adminify\Commands\CreateInterfacable;
use Ludows\Adminify\Commands\CreateInterfacableBlock;

use Ludows\Adminify\Commands\CreateCrud;
use Ludows\Adminify\Commands\CreateTable;
use Ludows\Adminify\Commands\CreateDropdown;
use Ludows\Adminify\Commands\CreateFormRequests;
use Ludows\Adminify\Commands\CreateForms;


use Illuminate\Support\Facades\Route;

use Illuminate\Contracts\Http\Kernel; // add kernel
use Ludows\Adminify\View\Components\Modal;

use Ludows\Adminify\Libs\HookManager;
use Ludows\Adminify\Facades\HookManagerFacade;


use File;
use Config;

class AdminifyServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    protected $namespace = '';

    public function boot(Kernel $kernel) {

        $app = app();

        if(!$app->runningInConsole()) {
            $packages = require_once(__DIR__.'/../config/packagelist.php');

            $this->bootableDependencies($packages, $kernel);
            $this->registerInstallablesCommands();
        }

        $this->bootDependencies();

        // dd(config('site-settings'));

        $this->registerPublishables();

        $this->loadApiRoutes();

        $this->mergeConfigFrom(
            __DIR__.'/../config/site-settings.php', 'adminify'
        );
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminify');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminify');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

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


        $this->app->bind('HookManager', function () {
            return new HookManager();
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

    private function registerPublishables() {
        $app = app();

        if($app->runningInConsole()) {
            $this->publishes(array(
                __DIR__.'/../resources/views/' => resource_path('views/vendor/adminify/'),
            ), 'adminify-views');

            $this->publishes(array(
                __DIR__.'/../resources/views/layouts/front' => resource_path('views/vendor/adminify/layouts/front'),
            ), 'adminify-views-front');

            $this->publishes(array(
                __DIR__.'/../resources/views/layouts/admin' => resource_path('views/vendor/adminify/layouts/admin'),
            ), 'adminify-views-admin');

            $this->publishes(array(
                __DIR__.'/../database/views/' => database_path('migrations'),
            ), 'adminify-migrations');
        }
    }

    private function loadApiRoutes() {
        $config = config('site-settings.restApi');

        // $this->routes(function () use ($config) {

            if(isset($config) && $config['enable']) {

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

        // });
    }

    private function registerInstallablesCommands() {
        $config = config('generators');
        $adminInstall = require_once(__DIR__.'/../config/adminify_generator_installation.php');

        $mergeSettings = array_merge($config['settings'], $adminInstall['settings']);
        $mergeStubs = array_merge($config['stubs'], $adminInstall['stubs']);


        config(['generators.settings' => []]);
        config(['generators.stubs' => []]);

        config(['generators.settings' => $mergeSettings]);
        config(['generators.stubs' => $mergeStubs]);
    }

    private function buildNamespace() {

    }

    private function bootDependencies() {
        $c = config('site-settings');
        $models = [];

        $pathModels = app_path('Models');
        $pathAdminifyModels = app_path('Adminify/Models');

        $paths = [
            $pathModels,
            $pathAdminifyModels
        ];

        //dd($paths);
        
        foreach ($paths as $pathable) {
            # code...
            if (!file_exists($pathable)) {
                // path does not exist
                return false;
            }
            $files = File::files($pathable);

            $namespaceBase = 'App\Models';

            foreach($files as $f){
                $namedClass = str_replace('.'.$f->getExtension(), '', $f->getBaseName());

                $fullModelClass = $namespaceBase . '\\'. $namedClass;
                $m = $fullModelClass;
                $model = app($fullModelClass);

                if(method_exists($model, 'getAliases')) {
                    $aliases = $model->getAliases();
                    foreach ($aliases as $alias) {
                        # code...
                        $models[ singular( $alias ) ] = $m;
                    }
                }

                $models[ singular( $model->getTable() ) ] = $m;
            }
        }

        

        config(['site-settings.register' => $models]);
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
            CreateFormRequests::class,
            CreateForms::class,
            CreateTable::class,
            CreateRepository::class,
            CreateController::class,
            CreateCrud::class,
            DoInstallEnv::class,
            CreateModel::class,
            CreateDropdown::class,
            CreateUser::class,
            GenerateFeeds::class,
            InstallPackages::class,
            RouteList::class,
            CreateTranslations::class,
            CreateInterfacable::class,
            CreateInterfacableBlock::class
        ]);
    }
}
