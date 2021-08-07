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
    protected $signature = 'adminify:install
        {task?* : Tasks name are npm, coreinstall, migrations, seed, publishes, rollback, feeds, routes, caches}
        {--force : Force all tasks, --firstInstall : Tell if is the first Install  of adminify}'; //todo

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

        $arguments = $this->arguments();
        $firstInstall = $this->option('firstInstall') != null ? true : false;

        $cleanedTasks = [];

        if(isset($arguments['task'])) {
            foreach ($arguments['task'] as $t) {
                # code...
                $cleanedTasks[] = str_replace('task=', '', $t);
            }
        }

        if(!in_array('*', $cleanedTasks) && count($arguments['task']) == 0) {
            $cleanedTasks[] = '*';
            $cleanedTasks[] = 'cache';
        }

        if($firstInstall) {
            Artisan::call('adminify:env');
        }

        if(in_array('*', $cleanedTasks) && !$firstInstall || in_array('rollback', $cleanedTasks) && !$firstInstall) {
            Artisan::call('migrate:rollback');
        }

        if(in_array('*', $cleanedTasks)  || in_array('coreinstall', $cleanedTasks)) {
            $this->info('Handle Adminify core instalation...');
            $this->handleCoreTasks();

            $this->info('Handle stubs install...');
            $this->handleStubs(base_path('vendor/ludows/adminify/stubs'));
            if(!in_array('*', $cleanedTasks)) {
                $this->doCommand('composer dump-autoload');
            }
        }

        if(in_array('*', $cleanedTasks)  || in_array('publishes', $cleanedTasks)) {
            $this->handlePublishesPackages();
        }
        
        if(in_array('*', $cleanedTasks)  || in_array('migrations', $cleanedTasks)) {
            $this->info('Handle migrations database...');
            Artisan::call('migrate');
        }

        if(in_array('*', $cleanedTasks)  || in_array('feeds', $cleanedTasks)) {
            $this->info('Handle feeds config generation...');
            Artisan::call('adminify:feeds');
        }

        if(in_array('*', $cleanedTasks)  || in_array('routes', $cleanedTasks)) {
            $this->info('Handle route list js...');
            Artisan::call('adminify:routes');
        }

        if(in_array('*', $cleanedTasks)  || in_array('translations', $cleanedTasks)) {
            $this->info('Handle Translations js...');
            Artisan::call('adminify:translations');
        }

        if(in_array('*', $cleanedTasks)  || in_array('cache', $cleanedTasks)) {
            $this->info('Clear all caches...');
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
        }

        //run seeds
        //exec("php artisan db:seed --class='Ludows\Adminify\Database\Seeders\DatabaseSeeder'");
        if(in_array('*', $cleanedTasks)  || in_array('seed', $cleanedTasks)) {
            $this->info('Handle seeding database...');
            Artisan::call('db:seed', [
                '--class' => 'Ludows\Adminify\Database\Seeders\DatabaseSeeder'
            ]);
        }

        if(in_array('*', $cleanedTasks)  || in_array('npm', $cleanedTasks)) {
            $this->info('Handle npm process...');
            $this->doCommand('npm install && npm run dev');
        }

        if(count($cleanedTasks) > 0) {
            $this->info('Installation finished.');
        }
        else {
            $this->info('No Tasks specified, Installation finished.');
        }
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
    public function dif_scandir($a = []) {
        $excludes = [
            '.',
            '..'
        ];
        return array_diff($a, $excludes);
    }
    public function constructPathFromNamespace($namespace) {

       $a = explode('\\', $namespace);
       $a = array_diff($a, ['', ' ']);
       $i = 0;
       $path = [];
       foreach ($a as $b) {
           # code...
           if($i == 0) {
            $path[] = strtolower($b);
           }
           else {
            $path[] = $b;
           }
           $i++;
       }

       return join(DIRECTORY_SEPARATOR, $path);

    }
    public function handleStubs($path = '', $namespaceStr = "\App",  $log = true) {

        $currentPath = $path;
        // dump($currentPath);
        $mixed =  $this->dif_scandir(scandir($currentPath));
        // dump($mixed_types, $namespaceStr);
        $namespace = $namespaceStr;

        foreach ($mixed as $mixed_type) {
            # code...
            // dump($mixed_type);
            if(!is_file($currentPath.'/'.$mixed_type) ){
                $namespaced = Str::title($mixed_type);
                $checkDirectories = scandir($currentPath.'/'.$mixed_type);
                if(count($checkDirectories) > 0) {
                    $this->handleStubs($currentPath.DIRECTORY_SEPARATOR.$mixed_type, $namespace.'\\'.$namespaced);
                }

                if($log) {
                    $this->info('Handle directory stub:  '. $currentPath.DIRECTORY_SEPARATOR.$mixed_type);
                    $this->info('Handle namespace stub:  '. $namespace.'\\'.$namespaced);
                }
            }
            if(is_file($currentPath.DIRECTORY_SEPARATOR.$mixed_type) && $namespace != '\App') {
                if(!class_exists($namespace)) {
                    $p = $this->constructPathFromNamespace($namespace);

                    if(!File::exists(base_path().DIRECTORY_SEPARATOR.$p)) {
                        \File::makeDirectory(base_path().DIRECTORY_SEPARATOR.$p, 0755, true, true);
                    }

                    $this->info('Handle copy of '.$namespace.'\\'.$mixed_type);
                    $info = pathinfo($currentPath.DIRECTORY_SEPARATOR.$mixed_type);
                    \File::copy( $currentPath.DIRECTORY_SEPARATOR.$mixed_type ,  base_path().DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR.$info['filename'].'.php' );
                }
                else {
                    $this->info('Skipping '.$namespace.'\\'.$mixed_type.' already present');
                }

                // if(!File::exists($backupLoc)) {
                //     File::makeDirectory($backupLoc, 0755, true, true);
                // }
            }
        }



    }
}
