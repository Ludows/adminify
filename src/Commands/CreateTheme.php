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

        $theme =  $this->formatArgument( $this->argument('theme'), 'theme=', '');

        if(!file_exists($theme_root_path)) {
            File::makeDirectory($theme_root_path);

            $this->info('Checking folder theme for '.$theme);

            $theme_folder = $theme_root_path.DIRECTORY_SEPARATOR.$theme;

            if(!file_exists($theme_folder)) {
               
                File::makeDirectory( $theme_folder );
                // File::copy( $task , $copyTask);
            }
            else {
                $this->info('theme named '. $theme .' folder exist!');
            }

        }
        else {
            $this->info('theme folder exist!');
        }


    }
}
