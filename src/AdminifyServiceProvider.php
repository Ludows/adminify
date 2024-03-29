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
use Ludows\Adminify\Commands\CreateApiController;
use Ludows\Adminify\Commands\CreateRepository;
use Ludows\Adminify\Commands\DoInstallEnv;
use Ludows\Adminify\Commands\CreateInterfacable;
use Ludows\Adminify\Commands\CreateInterfacableBlock;
use Ludows\Adminify\Commands\GenerateAdminifyContainer;
use Ludows\Adminify\Commands\CreateMetas;
use Ludows\Adminify\Commands\CreateTheme;
use Ludows\Adminify\Commands\CreateFrontForms;
use Ludows\Adminify\Commands\CreateShortcode;
use Ludows\Adminify\Commands\FlushCacheQuery;
use Ludows\Adminify\Commands\CreateDatabase;

use Ludows\Adminify\Commands\CreateCrud;
use Ludows\Adminify\Commands\CreateTable;
use Ludows\Adminify\Commands\CreateDropdown;
use Ludows\Adminify\Commands\CreateFormRequests;
use Ludows\Adminify\Commands\CreateForms;
use Ludows\Adminify\Commands\CreateHook;

use Illuminate\Support\Facades\Route;

use Illuminate\Contracts\Http\Kernel; // add kernel
use Ludows\Adminify\View\Components\Modal;

use Ludows\Adminify\Libs\HookManager;

use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;

use League\Glide\Signatures\SignatureFactory;

use Ludows\Adminify\Libs\SitemapRender;
use Ludows\Adminify\Libs\MediaService;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Blade;

// use Illuminate\Support\Facades\Storage;


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
        }

        Paginator::useBootstrap();

        $this->registerDirectives();

        // dd(config('site-settings'));

        $this->registerPublishables();

        $this->loadApiRoutes();

        $this->mergeConfigFrom(
            __DIR__.'/../config/site-settings.php', 'adminify'
        );
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminify');

        $this->loadCustomViewsPaths();

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'adminify');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

    public function registerDirectives() {

        Blade::directive('routeis', function ($expression) {
            return "<?php if (fnmatch({$expression}, Route::currentRouteName())) : ?>";
        });

        Blade::directive('endrouteis', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('routeisnot', function ($expression) {
            return "<?php if (! fnmatch({$expression}, Route::currentRouteName())) : ?>";
        });

        Blade::directive('endrouteisnot', function ($expression) {
            return '<?php endif; ?>';
        });

        Blade::directive('hook', function ($arguments) {
            $args = explode(',', $arguments);
            $trimmed_args = array_map('trim', $args);

            if(count($trimmed_args) < 2) {
                $trimmed_args[1] = null;
            }

            return "<?php echo app('HookManager')->exec(". join(', ', $trimmed_args) ."); ?>";
        });
    }

    public function loadCustomViewsPaths() {
        $paths = get_site_key('custom_views_paths');

        $isEmpty = empty($paths);

        if(!$isEmpty) {
            foreach ($paths as $key => $value) {
                # code...
                $this->loadViewsFrom($value, $key);
            }
        }

    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {

        // Register the service the package provides.
        define('IS_ADMINIFY', true);

        $this->app->singleton('adminify', function($app) {

            return new Adminify;
        });

        $this->app->singleton('League\Glide\Server', function($app) {

            // $filesystem = Storage::disk(config('lfm.disk'));

            $mediaService = app(MediaService::class);
            // // dd($filesystem->getDriver(), $filesystem->exists('files/1/IMG_20220302_112930-removebg-preview.png'), config('lfm.disk') );
            // $lfm = app()->make('UniSharp\LaravelFilemanager\LfmPath');
            // $source_path_prefix = '';
            // $path_image = request('path');



            // // dd($lfm->files());

            // foreach ($lfm->files() as $fileObject) {
            //     # code...
            //     // dd($fileObject->path('url'));
            //     $url = $fileObject->path('url');
            //     if($fileObject->name() == $path_image) {
            //         $source_path_prefix = trim(str_replace($path_image, '', $url));
            //         break;
            //     }
            // }

            return ServerFactory::create([
                'response' => new LaravelResponseFactory(app('request')),
                'source' => $mediaService->getFileSystem()->getDriver(),
                'cache' => $mediaService->getFileSystem()->getDriver(),
                'cache_path_prefix' => '.cache',
                'source_path_prefix' =>  '',
                'base_url' => 'images',
                'max_image_size' => 2000*2000,
            ]);
        });

        $this->app->singleton('League\Glide\Signatures\Signature', function($app) {
            return SignatureFactory::create(env('GLIDE_SECURE_KEY'));
        });

        $this->app->singleton('Ludows\Adminify\Libs\SitemapRender', function($app) {
            return new SitemapRender();
        });

        $this->app->bind('HookManager', function () {
            return new HookManager();
        });

        $this->app->bind('ThemeManager', function () {
            return new \Ludows\Adminify\Libs\ThemeManager();
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
                __DIR__.'/../config/site-settings.php' => config_path('site-settings.php'),
            ), 'adminify-config');

            $this->publishes(array(
                __DIR__.'/../resources/views/' => resource_path('views/vendor/adminify/'),
            ), 'adminify-views');

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
            CreateDatabase::class,
            CreateFormRequests::class,
            GenerateAdminifyContainer::class,
            CreateForms::class,
            CreateTable::class,
            CreateTheme::class,
            CreateRepository::class,
            CreateController::class,
            CreateApiController::class,
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
            CreateInterfacableBlock::class,
            CreateMetas::class,
            CreateFrontForms::class,
            CreateShortcode::class,
            FlushCacheQuery::class,
            CreateHook::class
        ]);
    }
}
