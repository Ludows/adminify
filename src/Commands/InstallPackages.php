<?php

namespace Ludows\Adminify\Commands;

use Symfony\Component\Process\Process;

use Illuminate\Support\Facades\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
// use Illuminate\Support\Facades\Event;
use File;
class InstallPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:install {—-publish : Handle Publishes Packages,
        —-coreinstall : Handle Core Install,
        --migrations : Handle migrations,
        --npm : run Npm }';

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
        //@todo aliases and autoregister services providers..

        $this->packages = require_once(__DIR__.'/../../config/packagelist.php');
        $this->tasks = require_once(__DIR__.'/../../config/coretasks.php');
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $options = $this->options();

        dd($options);

        
        // if(!isset($options['noCoreInstall']))
        $this->info('Handle Adminify core instalation');
        $this->handleCoreTasks();
        
        $this->info('Handle stubs install');
        $this->handleStubs(base_path('vendor/ludows/adminify/stubs'));

        $this->handlePublishesPackages();

        //run migration for tables
        // exec("php artisan migrate");
        $this->info('Handle migrations');
        Artisan::call('migrate');

        //run seeds
        //exec("php artisan db:seed --class='Ludows\Adminify\Database\Seeders\DatabaseSeeder'");
        $this->info('Handle seeding database');
        Artisan::call('db:seed', [
            '--class' => 'Ludows\Adminify\Database\Seeders\DatabaseSeeder'
        ]);
        
        $this->info('Handle npm process');
        $this->doCommand('npm install && npm run dev');
        
        $this->info('Installation finished.');
        

    }
    /**
     * Execute a command
     *
     * @param [type] $command
     * @return void
     */
    private function doCommand($command)
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(null); // Setting timeout to null to prevent installation from stopping at a certain point in time

        $process->setWorkingDirectory(base_path())->run(function ($type, $buffer) {
            $this->line($buffer);
        });
    }
    public function handleHook($package, $key, $log = true) {
        $commands = $package->{$key};
        if(count($commands) > 0) {

            foreach ($commands as $command) {
                # code...
                if($log) {
                    $this->info('Handle '. $key .' hook command:  '. $command);
                }
                exec($command);
            }

        }
    }
    public function handlePublishesPackages() {
        foreach ($this->packages as $dependency) {
            # code...

            
            $command = $this->handlePackageInstall($dependency);

            // handle beforePublish
            $this->handleHook($dependency, 'beforePublish');
            //first exec command package
            if($command != null) {
                exec($command);
            }

            // handle afterPublish
            $this->handleHook($dependency, 'afterPublish');

            //second publish my preconfigured files config
            $this->handleConfig($dependency);

        }
    }
    public function handleCoreTasks($log = true) {
        // FilecopyDirectory

        foreach ($this->tasks as $task => $copyTask) {
            # code...
            if(\File::exists($copyTask)){
                File::delete($copyTask);
            }

            if(File::isDirectory($task)) {
                File::copyDirectory($task, $copyTask);
            }
            else {
                \File::copy( $task , $copyTask);
            }

            if($log) {
                $this->info('Handle File copy:  '. $copyTask);
            }
        }

    }
    public function handlePackageInstall($package, $log = true) {
        $firstPackagePublish = $package->publish;

        $currentPublishInstall = null;

        if($firstPackagePublish != null) {
            $forceStr = '';

            if($firstPackagePublish->force) {
                $forceStr = ' --force';
            }

            $handlePublish = '--provider="'.$firstPackagePublish->sibling.'" '.$forceStr.'';

            if($firstPackagePublish->tag) {
                $handlePublish = '--tag="'.$firstPackagePublish->sibling.$forceStr.'" '.$forceStr.'';
            }

            $currentPublishInstall = 'php artisan vendor:publish '. $handlePublish .'';

            if($log) {
                $this->info('Handle console command:  '. $currentPublishInstall);
            }
        }

        return $currentPublishInstall;
    }
    public function handleConfig($package, $log = true) {
        $firstPackageConfig = $package->config;

        if($firstPackageConfig != null) {

            \File::copy( __DIR__.$firstPackageConfig->file.'.php' , config_path($firstPackageConfig->name.'.php'));

            if($log) {
                $this->info('Handle published config:  '. $firstPackageConfig->name);
            }
        }
    }
    public function handleStubs($path = '', $namespaceStr = '',  $log = true) {

        $currentPath = $path;

        $dirs = \Storage::allDirectories($path);
        $namespace = $namespaceStr ?? "App\\";

        foreach ($dirs as $dir) {
            # code...
            $namespaced = Str::title($dir);
            $checkDirectories = \Storage::allDirectories($currentPath.'/'.$dir);
            if(count($checkDirectories) > 0) {
                $this->handleStubs($currentPath.'/'.$dir, $namespace.'\\'.$namespaced);
            }

            $files = \Storage::allFiles($currentPath.'/'.$dir);

            foreach ($files as $file) {
                # code...
                $info = pathinfo($file);
            }

            if($log) {
                $this->info('Handle directory stub:  '. $currentPath.'/'.$dir);
                $this->info('Handle namespace stub:  '. $namespace);
            }
        }



    }
}
