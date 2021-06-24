<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Support\Facades\Route;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
// use Illuminate\Support\Facades\Event;


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
        
        $this->packages = require_once(__DIR__.'../config/packagelist.php');
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $command = $this->handlePackageInstall($this->packages[0]);

        // run first command and execute all then after..
        Artisan::call($command, []);

        foreach ($this->packages as $dependency) {
            # code...
            $command = $this->handlePackageInstall($dependency);
            
            Artisan::call($command, []);

        }
        
    }
    public function handlePackageInstall($package, $log = true) {
        $firstPackagePublish = $package->publish;

        $handlePublish = '--provider="'.$firstPackagePublish->sibling.'';

        if($firstPackagePublish->tag) {
            $handlePublish = '--tag="'.$firstPackagePublish->sibling.'';
        }

        $currentPublishInstall = 'php artisan vendor:publish '. $handlePublish .'';

        if($log) {
            $this->info('Handle console command:  '. $currentPublishInstall);
        }

        return $currentPublishInstall;
    }
}
