<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use File;

class ScafoldEnvironnements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:scafold {--task=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a classic scafold for Adminify for your back or frontend override';

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
        $theme_root_path = theme_path();
        $package_vendor_path = $this->pathFromPackageScafold();
        $dest_Path = $this->createPathFromResources();
        $tasks = $this->option('task') ?? [];
        $dest_folders = [];
        $wasFired = false;

        if(in_array('*', $tasks)) {
            // execute back and front
            $dest_folders = ['back', 'front'];
            $wasFired = true;
        }

        if(in_array('front', $tasks) && in_array('back', $tasks)) {
            // execute back and front
            $dest_folders = ['back', 'front'];
            $wasFired = true;
        }

        if(in_array('front', $tasks) && !$wasFired) {
            // execute front
            $dest_folders = ['front'];
            $wasFired = true;
        }

        if(in_array('back', $tasks) && !$wasFired) {
            // execute front
            $dest_folders = ['back'];
            $wasFired = true;
        }

        // dd($tasks, $dest_folders);


        foreach ($dest_folders as $key => $folder) {
            # code...
            $currnt_path = $dest_Path.DIRECTORY_SEPARATOR.$folder;
            $layout_path = $currnt_path.DIRECTORY_SEPARATOR.'layouts';
            $file_path = $currnt_path.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'app-'.$folder.'.blade.php';
            $partial_path = $currnt_path.DIRECTORY_SEPARATOR.'layouts'.DIRECTORY_SEPARATOR.'partials';
            $existRootDir = $this->checkDir( $currnt_path );
            $existLayoutDir = $this->checkDir( $layout_path );
            $existPartialsDir = $this->checkDir( $partial_path );
            $existFileApp = $this->checkFile( $file_path );

            if(!$existRootDir) {
                $this->makeDirectory($currnt_path);
            }
            if(!$existLayoutDir) {
                $this->makeDirectory($layout_path);
            }
            if($folder == 'front' && !$existPartialsDir) {
                $this->copyDir( $this->pathFromPackageScafold('layouts/partials') , $this->createPathFromResources($folder.'/layouts/partials/'));
            }
            if(!$existFileApp) {
                $this->copyFile( $this->pathFromPackageScafold('layouts/app-'.$folder.'.blade.php'), $this->createPathFromResources($folder.'/layouts/app.blade.php'));
            }

            
        }
    }
    public function createPathFromResources($path = '') {
       return resource_path('views/'.$path);
    }
    public function pathFromPackageScafold($path = '') {
        return vendor_path('/ludows/adminify/src/Scafold_Structure/'.$path);
    }
    public function copyFile($source = '', $destPath = '') {
        File::copy($source, $destPath);
    } 
    public function copyDir($source = '', $destPath = '') {
        File::copyDirectory($source, $destPath);
    } 
    public function checkDir($path = '') {
        return File::isDirectory($path);        
    }
    public function checkFile($path = '') {
        return File::exists($path);        
    }
    public function makeDirectory($path = '') {
        File::makeDirectory($path);
    }
}
