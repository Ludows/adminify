<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:resources 
                        {model : model name}
                        {type : registred types are content, classic} 
                        {--fields= : Fields for the form}
                        {--schema= : Schema db}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to scafold Crud resource for Adminify';

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
        $fields = $this->option('fields');
        $schema = $this->option('schema');

        $model = Str::title($model ?? '');

        // ensure his plurial name
        $model = Str::plural($model);

        //dump('$typeModel', $typeModel);


        $this->info('Do DB file Creation for your entity...');
        $this->call('generate:migration', [
            'name' => 'create_'. Str::lower($model) .'_table',
            '--model' => false, // disable automatic generation model
            '--schema' => $schema ?? [],
        ]);

        $this->info('Create Controller for your entity...');
        $this->call('adminify:controller', [
            'model' => Str::singular($model),
        ]);

        $this->info('Create Api Controller for your entity...');
        $this->call('adminify:api_controller', [
            'model' => Str::singular($model),
        ]);
        
        $this->info('Create Model for your entity...');
        $this->call('adminify:model', [
            'model' => Str::singular($model) ,
            'type' => $typeModel,
        ]);

        $this->info('Create Table Listing for your entity...');
        $this->call('adminify:table', [
            'model' => Str::singular($model),
        ]);
    
        $this->info('Create Dropdown for Actions in your Table Listing for your entity...');
        $this->call('adminify:dropdown', [
            'model' => Str::singular($model),
        ]);

        $this->info('Create CRUD Form Requests for your entity ...');
        $this->call('adminify:form_request', [
            'model' => Str::singular($model),
        ]);

        $this->info('Create CRUD Forms for your entity...');
        $this->call('adminify:form', [
            'model' => Str::singular($model),
            '--fields' => $fields ?? []
        ]);

        $this->info('Create Repository for your entity...');
        $this->call('adminify:repository', [
            'model' => Str::singular($model),
        ]);
        

        $this->info('FULL CRUD PATTERN CREATED FOR '.$model);

        // Artisan::call('make:model '.$model);
        // $this->info('Model '.$model.' created');

        // Artisan::call('make:controller '.$model);
        // $this->info('Model '.$model.' created');
    }
}
