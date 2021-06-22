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
                'beforePublish' => [],
                'name' => 'artesaos/seotools',
                'publishes' => ['Artesaos\SEOTools\Providers\SEOToolsServiceProvider'],
                'config' => '../config/seotools',
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'diglactic/laravel-breadcrumbs',
                'publishes' => null,
                'config' => '../config/breadcrumbs',
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'kris/laravel-form-builder',
                'publishes' => null,
                'config' => '../config/laravel-form-builder',
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'laracasts/flash',
                'publishes' => ['Laracasts\Flash\FlashServiceProvider'],
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'mratiebatie/laravel-repositories',
                'publishes' => null,
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'nadar/quill-delta-parser',
                'publishes' => null,
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'silviolleite/laravelpwa',
                'publishes' => ['LaravelPWA\Providers\LaravelPWAServiceProvider'],
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/laravel-backup',
                'publishes' => ['Spatie\Backup\BackupServiceProvider'],
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/laravel-menu',
                'publishes' => ['Spatie\Menu\Laravel\MenuServiceProvider'],
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/laravel-permission',
                'publishes' => ['Spatie\Permission\PermissionServiceProvider'],
                'config' => '../config/permission',
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/laravel-searchable',
                'publishes' => null,
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/laravel-translatable',
                'publishes' => ['Spatie\Translatable\TranslatableServiceProvider'],
                'config' => '../config/translatable',
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'spatie/menu',
                'publishes' => ['Spatie\Menu\Laravel\MenuServiceProvider'],
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'thunderer/shortcode',
                'publishes' => null,
                'config' => null,
                'afterPublish' => [],
            ),
            (object) array(
                'beforePublish' => [],
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
                'beforePublish' => [],
                'name' => 'van-ons/laraberg',
                'publishes' => ['VanOns\Laraberg\LarabergServiceProvider'],
                'config' => '../config/laraberg',
                'afterInstall' => [],
            ),
            (object) array(
                'beforePublish' => [],
                'name' => 'ycs77/laravel-form-builder-bs4',
                'publishes' => ['laravel-form-builder-bs4'],
                'config' => '../config/laraberg',
                'afterInstall' => [],
            ),
            (object) array(
                'beforePublish' => [],
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
        $currentPublishInstall = 'php artisan vendor:publish --provider="'.$this->packages[0]->name.'"';

        Event::listen('Illuminate\Console\Events\CommandFinished', function ($event) use ($currentPublishInstall) {
            if ($event->command == $currentPublishInstall) {
                // do stuff on finish
            }
        });

        foreach ($this->packages as $dependency) {
            # code...
            $this->info('Running console command:  '. $currentPublishInstall);

            // $installationPackage = Artisan::call('composer require '.$dependency->name, []);

            $currentPublishInstall = 'composer require '.$dependency->name;

        }
        
    }
}
