<?php

namespace Ludows\Adminify\Commands;

use Symfony\Component\Process\Process;

use Illuminate\Support\Facades\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Event;
use File;


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
        //@todo aliases and autoregister services providers..

        $this->packages = require_once(__DIR__.'/../../config/packagelist.php');
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
    public function handlePackageInstall($package, $log = true) {
        $firstPackagePublish = $package->publish;

        $currentPublishInstall = null;

        if($firstPackagePublish != null) {
            $handlePublish = '--provider="'.$firstPackagePublish->sibling.'"';

            if($firstPackagePublish->tag) {
                $handlePublish = '--tag="'.$firstPackagePublish->sibling.'"';
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
}
