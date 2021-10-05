<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

use File;

class GenerateAdminifyContainer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:container';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for create adminify configuration file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->registerLaravelApp();
    }

    private function registerLaravelApp() {

        // $pathModels = app_path('Models');
        // $pathAdminifyModels = app_path('Adminify/Models');
        
        $bootables = $this->bootDependencies(app_path(), null, []);
        $globals = $this->getClassesBootables($bootables);
        cache(['adminify.autoload' => $globals]);
    }

    private function getClassesBootables($bootables) {

        $gloablBoot = $bootables;

        foreach ($bootables as $bootableKey => $bootable) {
            # code...
            $classes = \HaydenPierce\ClassFinder\ClassFinder::getClassesInNamespace($bootable);

            if(!empty($classes)) {

                $registrar = [];

                foreach ($classes as $laravelNamespace) {
                    # code...
                    $split = explode('\\', $laravelNamespace);
                    $label = $split[ count($split) - 1 ];

                    $registrar[ $label ] = $laravelNamespace;
                    
                    if(in_array($bootableKey, ['app:models', 'app:adminify:models'])) {
                        $m = new $laravelNamespace;
                        if(method_exists($m, 'getAdminifyAliases')) {
                            $aliases = $m->getAdminifyAliases();
                            foreach ($aliases as $alias) {
                                # code...
                                $registrar[ $alias ] = $laravelNamespace;
                            }
                        }
                    }
                }
                $gloablBoot[$bootableKey] = $registrar;
            }
            else {
                unset($gloablBoot[$bootableKey]);
            }
        }

        return $gloablBoot;
    }

    private function getDirectories($path) {
        return File::directories($path);
    }

    private function hasSubDirectories($path) {
        return count(File::directories($path)) > 0 ? true : false;
    }

    private function bootDependencies($path, $labelOverride,  $array) {
        $hasDirs = $this->getDirectories($path);

        $namespaces = [];

        if(!empty($hasDirs)) {

            foreach ($hasDirs as $dirPath) {
                # code...
                $explode_path = explode(DIRECTORY_SEPARATOR, $dirPath);

                $getN = array_slice($explode_path, 6);

                foreach ($getN as $NKey => $N) {
                    # code...
                    $getN[$NKey] = Str::ucfirst($N);

                }

                $namescaped = join('\\', $getN);

                // dd($getN, $namescaped);

                $labelize = join(':' , $getN);

                $folder = strtolower($labelize);

                if($this->hasSubDirectories($dirPath)) {

                    $subfolder = $this->bootDependencies($dirPath, $folder, $array);
                    $namespaces = array_merge($namespaces, $subfolder);
                }

                $namespaces[ strtolower($folder) ] = $namescaped;



            }

        }

        return $namespaces;
    }
}
