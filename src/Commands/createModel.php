<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class CreateModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:model {name: Name of your Model, type : can be content or classic} {--path : desired path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to make a Adminify Model';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../../templates/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
    }
}
