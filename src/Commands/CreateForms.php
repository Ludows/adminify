<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CreateForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:form {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate forms according to crud pattern';

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

        $names = [
            'Create'.Str::title($model).'Form',
            'Update'.Str::title($model).'Form',
        ];

        foreach ($names as $n) {
            # code...
            Artisan::call('make:form', [
                'name' => $n
            ]);
            $this->info($n.' Created');
        }
    }
}
