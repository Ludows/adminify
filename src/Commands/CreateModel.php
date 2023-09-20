<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:model 
                        {model : model name}
                        {type : registred types are content, classic}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a Adminify Model';

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
        $typeModel = $this->formatArgument( $this->argument('type') , 'type=', '') == 'content' ? 'adminify_model_content_type' : 'adminify_model_classic';

        $model = Str::title($model ?? '');

        // // ensure his plurial name
        // $model = Str::plural($model);

        //dump('$typeModel', $typeModel);


        $this->call('generate:model', [
            'name' => Str::singular($model) ,
            '--stub' => $typeModel,
        ]);


    }
}
