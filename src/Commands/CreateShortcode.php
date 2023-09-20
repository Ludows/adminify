<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateShortcode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:shortcode
                                {model : model name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a Little Shortcode';

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

        $model =  $this->formatArgument( $this->argument('model'), 'model=', '');

        $model = Str::title($model ?? '');

        $this->call('generate:file', [
            'name' => $model,
            '--type' => 'shortcodes',
            '--stub' => 'adminify_shortcode'
        ]);

        // $this->call('adminify:dropdown', [
        //     'model' => Str::singular($model),
        //     '--stub' => 'adminify_dropdown',
        //     '--type' => 'dropdown'
        // ]);

    }
}
