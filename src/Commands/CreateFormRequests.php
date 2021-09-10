<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateFormRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:form_request {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate form requests according to crud pattern';

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

        $formRequestNames = [
            'Create'.Str::singular($model),
            'Update'.Str::singular($model)
        ];
        foreach ($formRequestNames as $formRequestName) {
            # code...
            $this->call('generate:request', [
                'name' =>  $formRequestName
            ]);
        }
    }
}
