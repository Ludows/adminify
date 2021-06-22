<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Support\Facades\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;


class InstallPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to Install all required packages of adminify project.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->packages = array(
            (object) array(
                'name' => 'artesaos/seotools',
                'publishes' => ['Artesaos\SEOTools\Providers\SEOToolsServiceProvider'],
                'config' => '../config/seotools'
            ),
            (object) array(
                'name' => 'diglactic/laravel-breadcrumbs',
                'publishes' => null,
                'config' => '../config/breadcrumbs'
            ),
            (object) array(
                'name' => 'kris/laravel-form-builder',
                'publishes' => null,
                'config' => '../config/laravel-form-builder'
            ),
            (object) array(
                'name' => 'laracasts/flash',
                'publishes' => ['Laracasts\Flash\FlashServiceProvider'],
                'config' => null
            ),
            (object) array(
                'name' => 'mratiebatie/laravel-repositories',
                'publishes' => null,
                'config' => null
            ),
            (object) array(
                'name' => 'nadar/quill-delta-parser',
                'publishes' => null,
                'config' => null
            ),
            (object) array(
                'name' => 'silviolleite/laravelpwa',
                'publishes' => ['LaravelPWA\Providers\LaravelPWAServiceProvider'],
                'config' => null
            ),
            (object) array(
                'name' => 'spatie/laravel-backup',
                'publishes' => ['Spatie\Backup\BackupServiceProvider'],
                'config' => null
            ),
            (object) array(
                'name' => 'spatie/laravel-menu',
                'publishes' => ['Spatie\Menu\Laravel\MenuServiceProvider'],
                'config' => null
            ),
            (object) array(
                'name' => 'spatie/laravel-permission',
                'publishes' => ['Spatie\Permission\PermissionServiceProvider'],
                'config' => '../config/permission'
            ),
            (object) array(
                'name' => 'spatie/laravel-searchable',
                'publishes' => null,
                'config' => null
            ),
            (object) array(
                'name' => 'spatie/laravel-translatable',
                'publishes' => ['Spatie\Translatable\TranslatableServiceProvider'],
                'config' => '../config/translatable'
            ),
            (object) array(
                'name' => 'spatie/menu',
                'publishes' => ['Spatie\Menu\Laravel\MenuServiceProvider'],
                'config' => null
            ),
            (object) array(
                'name' => 'thunderer/shortcode',
                'publishes' => null,
                'config' => null
            ),
            (object) array(
                'beforeInstall' => [],
                'name' => 'unisharp/laravel-filemanager',
                'publishes' => null,
                'config' => null,
                'afterInstall' => [
                    'php artisan vendor:publish --tag=lfm_config',
                    'php artisan vendor:publish --tag=lfm_public',
                    'php artisan storage:link'
                ],
            ),
            (object) array(
                'beforeInstall' => [],
                'name' => 'van-ons/laraberg',
                'publishes' => ['VanOns\Laraberg\LarabergServiceProvider'],
                'config' => '../config/laraberg',
                'afterInstall' => [],
            ),
            (object) array(
                'beforeInstall' => [],
                'name' => 'ycs77/laravel-form-builder-bs4',
                'publishes' => ['laravel-form-builder-bs4'],
                'config' => '../config/laraberg',
                'afterInstall' => [],
            ),
            (object) array(
                'beforeInstall' => [],
                'name' => 'zerospam/laravel-gettext',
                'publishes' => null,
                'config' => '../config/laravel-gettext',
                'afterInstall' => [],
            )
        );
        //@todo aliases and autoregister services providers..
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentCommandInstall = 'composer require '.$this->packages[0]->name;

        Event::listen('Illuminate\Console\Events\CommandFinished', function ($event) use ($currentCommandInstall) {
            if ($event->command == $currentCommandInstall) {
                // do stuff on finish
            }
        });

        foreach ($this->packages as $dependency) {
            # code...
            $this->info('Running console command:  '. $currentCommandInstall);

            $installationPackage = Artisan::call('composer require '.$dependency->name, []);

            $currentCommandInstall = 'composer require '.$dependency->name;

        }
        
    }
    public 
}
