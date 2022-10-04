<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Filesystem\Filesystem;

use Symfony\Component\Process\Process;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use File;
class InstallPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:install
        {task?* : Tasks name are npm, coreinstall, migrations, seed, publishes, feeds, routes, caches, refresh}
        {--force : Force all tasks}
        {--firstInstall : Tell if is the first Install  of adminify}'; //todo

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
        $this->excludesTasks = [
            'adminify:install:facades',
            'adminify:install:helpers',
            'adminify:install:libs',
            'adminify:install:traits',
            'adminify:install:view',
            'adminify:install:theme_structure'
        ];
        $this->excludesFiles = [
            'ClassicMail.php',
            'ClassicAuthUser.php',
            'ClassicModel.php',
            'ClassicUser.php',
            'ContentTypeModel.php'
        ];

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

        if(in_array('*', $cleanedTasks) && !$firstInstall || in_array('refresh', $cleanedTasks) && !$firstInstall) {
            $this->call('migrate:refresh');
            $this->refreshImages();
        }

        if(in_array('*', $cleanedTasks)  || in_array('coreinstall', $cleanedTasks)) {
            $this->info('Handle Adminify core instalation...');
            $this->handleCoreTasks();

            $this->info('Handle stubs install...');
            $this->registerInstallablesCommands();

            $this->handleStubs(base_path('vendor/ludows/adminify/src'), 'adminify:install');
            if(!in_array('*', $cleanedTasks)) {
                $this->doCommand('composer dump-autoload');
            }
        }

        if(in_array('*', $cleanedTasks)  || in_array('publishes', $cleanedTasks)) {
            $this->handlePublishesPackages();
        }

        if(in_array('*', $cleanedTasks)  || in_array('migrations', $cleanedTasks)) {
            $this->info('Handle migrations database...');
            $this->call('migrate');
        }

        

        if(in_array('*', $cleanedTasks)  || in_array('routes', $cleanedTasks)) {
            $this->info('Handle route list js...');
            $this->call('adminify:routes');
        }

        if(in_array('*', $cleanedTasks)  || in_array('translations', $cleanedTasks)) {
            $this->info('Handle Translations js...');
            $this->call('adminify:translations');
        }

        if(in_array('*', $cleanedTasks) && !$firstInstall  || in_array('cache', $cleanedTasks) && !$firstInstall) {
            $this->doClearCaches();
            $this->info('Handle Adminify cache...');
            $this->call('adminify:container');
        }

        if(in_array('*', $cleanedTasks)  || in_array('feeds', $cleanedTasks)) {
            $this->info('Handle feeds config generation...');
            $this->call('adminify:feeds');
        }

        //run seeds
        //exec("php artisan db:seed --class='Ludows\Adminify\Database\Seeders\DatabaseSeeder'");
        if(in_array('*', $cleanedTasks) && !$firstInstall  || in_array('seed', $cleanedTasks) && !$firstInstall) {
            $this->info('Handle seeding database...');
            $this->call('db:seed', [
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


    public function doClearCaches() {
        $this->info('Clear all caches...');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('view:clear');
    }

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

    public function refreshImages() {
        $file = new Filesystem;
        $file->cleanDirectory('storage/app/public');
    }

    private function registerInstallablesCommands() {
        $config = config('generators');
        $adminInstall = require_once(__DIR__.'/../../config/adminify_generator_installation.php');

        $mergeSettings = array_merge($config['settings'], $adminInstall['settings']);
        $mergeStubs = array_merge($config['stubs'], $adminInstall['stubs']);


        config(['generators.settings' => []]);
        config(['generators.stubs' => []]);

        config(['generators.settings' => $mergeSettings]);
        config(['generators.stubs' => $mergeStubs]);

        // dd(config());
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
    public function handleStubs($path = '', $type = null, $log = true) {
        $hasDirs = File::directories($path);
        $hasFiles = File::files($path);

        if(!empty($hasFiles) && $type != 'adminify:install') {

            $this->info('Files detected in '.$path);


            foreach ($hasFiles as $fileObject) {
                $typologie = $fileObject->getFilename();

                if(!in_array($typologie, $this->excludesFiles)) {
                    # code...
                     $this->call('generate:file', [
                        'name' => str_replace('.'.$fileObject->getExtension(), '',  $fileObject->getBasename()) ,
                        '--stub' => $type,
                        '--type' => $type,
                    ]);
                }
            }

        }

        if(!empty($hasDirs)) {
            foreach ($hasDirs as $dirPath) {
                # code...
                $list = explode(DIRECTORY_SEPARATOR, $dirPath);

                $typologie = $type .':'. strtolower( $list[ count($list) - 1 ] );

                if(!in_array($typologie, $this->excludesTasks)) {
                    $this->handleStubs($dirPath, $typologie);
                }
            }

        }
    }
    //the old way to install Adminify..
    // public function handleStubs($path = '', $namespaceStr = "\App",  $log = true) {

    //     $currentPath = $path;
    //     // dump($currentPath);
    //     $mixed =  $this->dif_scandir(scandir($currentPath));
    //     // dump($mixed_types, $namespaceStr);
    //     $namespace = $namespaceStr;

    //     foreach ($mixed as $mixed_type) {
    //         # code...
    //         // dump($mixed_type);
    //         if(!is_file($currentPath.'/'.$mixed_type) ){
    //             $namespaced = Str::title($mixed_type);
    //             $checkDirectories = scandir($currentPath.'/'.$mixed_type);
    //             if(count($checkDirectories) > 0) {
    //                 $this->handleStubs($currentPath.DIRECTORY_SEPARATOR.$mixed_type, $namespace.'\\'.$namespaced);
    //             }

    //             if($log) {
    //                 $this->info('Handle directory stub:  '. $currentPath.DIRECTORY_SEPARATOR.$mixed_type);
    //                 $this->info('Handle namespace stub:  '. $namespace.'\\'.$namespaced);
    //             }
    //         }
    //         if(is_file($currentPath.DIRECTORY_SEPARATOR.$mixed_type) && $namespace != '\App') {
    //             if(!class_exists($namespace)) {
    //                 $p = $this->constructPathFromNamespace($namespace);

    //                 if(!File::exists(base_path().DIRECTORY_SEPARATOR.$p)) {
    //                     \File::makeDirectory(base_path().DIRECTORY_SEPARATOR.$p, 0755, true, true);
    //                 }

    //                 $this->info('Handle copy of '.$namespace.'\\'.$mixed_type);
    //                 $info = pathinfo($currentPath.DIRECTORY_SEPARATOR.$mixed_type);
    //                 \File::copy( $currentPath.DIRECTORY_SEPARATOR.$mixed_type ,  base_path().DIRECTORY_SEPARATOR.$p.DIRECTORY_SEPARATOR.$info['filename'].'.php' );
    //             }
    //             else {
    //                 $this->info('Skipping '.$namespace.'\\'.$mixed_type.' already present');
    //             }

    //             // if(!File::exists($backupLoc)) {
    //             //     File::makeDirectory($backupLoc, 0755, true, true);
    //             // }
    //         }
    //     }



    // }
}
