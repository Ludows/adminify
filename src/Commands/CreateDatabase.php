<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:create_db 
                        {name? : db name}
                        {driver? : all drivers in connections database area}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create Database if not exist for Adminify';

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
        $driverArg = $this->argument('driver');
        $nameArg = $this->argument('name');
        $name = null;
        $driver = null;

        if(!empty( $nameArg)) {
            $name =  $this->formatArgument( $this->argument('name'), 'name=', '');
        }
        if(!empty($driverArg)) {
            $driver =  $this->formatArgument( $this->argument('driver'), 'driver=', '');
        }

        if(empty($driver)) {
            $driver = 'mysql';
        }

        if(empty($name)) {
            $name = config('database.connections.'. $driver .'.database');
        }

        try {
            $this->info('Trying to test if db is present...');
            DB::statement("SELECT 1");
        } catch (\Exception $e) {

            $this->alert("No db here, we try to create db named :". $name);
            $pdo = new \PDO(
                "". $driver .":host=".config('database.connections.'. $driver .'.host').";",
                config('database.connections.'. $driver .'.username'),
                config('database.connections.'. $driver .'.password')
            );
            $pdo->exec("CREATE DATABASE IF NOT EXISTS ".$name.";");

            $this->info('db with name : '. $name .' is created !');
            unset($pdo);
        }

        
    }
}
