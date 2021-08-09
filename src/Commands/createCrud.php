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
    protected $signature = 'adminify:resources {model}';

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

        // Artisan::call('make:model '.$model);
        // $this->info('Model '.$model.' created');

        // Artisan::call('make:controller '.$model);
        // $this->info('Model '.$model.' created');
    }
}
