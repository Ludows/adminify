<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:resources {model, typeModel}';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $model = $this->argument('model');
        $typeModel = $this->argument('typeModel') == 'content' ? 'content' : 'classic';

        $this->info('Do DB file Creation for your entity...');
        Artisan::call('adminify:migration_file', [
            'model' => $model 
        ]);

        $this->info('Create Controller for your entity...');
        Artisan::call('adminify:controller', [
            'model' => $model 
        ]);

        $this->info('Create Model for your entity...');
        Artisan::call('adminify:model', [
            'model' => $model ,
            'type' => $typeModel
        ]);

        $this->info('Create Table Listing for your entity...');
        Artisan::call('adminify:table', [
            'model' => $model 
        ]);
        
        $this->info('Create Dropdown for Actions in your Table Listing for your entity...');
        Artisan::call('adminify:dropdown', [
            'model' => $model 
        ]);

        $this->info('Create CRUD Form Requests for your entity ...');
        Artisan::call('adminify:form_request', [
            'model' => $model 
        ]);

        $this->info('Create CRUD Forms for your entity...');
        Artisan::call('adminify:form', [
            'model' => $model 
        ]);

        $this->info('Create Repository for your entity...');
        Artisan::call('adminify:repository', [
            'model' => $model 
        ]);
        

        // Artisan::call('make:model '.$model);
        // $this->info('Model '.$model.' created');

        // Artisan::call('make:controller '.$model);
        // $this->info('Model '.$model.' created');
    }
}
