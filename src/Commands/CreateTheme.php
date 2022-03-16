<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use File;

class CreateTheme extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:theme {theme : theme name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a classic theme for Adminify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function formatArgument(string $argument, string $strToMatch = '', string $strClear = '') {
        return str_replace($strToMatch, $strClear, $argument);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $theme_root_path = theme_path();
        $package_vendor_path = vendor_path('/ludows/adminify/src/Theme_Structure');

        $theme =  $this->formatArgument( $this->argument('theme'), 'theme=', '');

        $a = $this->makeDirectory($theme_root_path);

        // if(!$a) {
            $this->info('Checking folder theme for '.$theme);

            $theme_folder = $theme_root_path.DIRECTORY_SEPARATOR.$theme;

            $b = $this->makeDirectory($theme_folder);

            // if(!$b) {
                $this->info('Copy basic structure theme for '.$theme);
                File::copyDirectory($package_vendor_path, $theme_folder);
            // }
        // }



    }
    public function makeDirectory($path) {
        $alreadyExist = false;
        if(!file_exists($path)) {
            File::makeDirectory($path);
        }
        else {
            $this->info($path.' exist!');
            $alreadyExist = true;
        }
        return $alreadyExist;
    }
}
