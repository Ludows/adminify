<?php

namespace Ludows\Adminify\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class DoInstallEnv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminify:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for install user , password and db name for adminify';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function setEnvironmentValue(array $values)
    {

        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {

                $str .= "\n"; // In case the searched variable is in the last line without \n
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }

            }
        }

        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $keys = [];

        $app_url = $this->ask(__('adminify.questions.app_url'));
        
        $keys['APP_URL'] = $app_url;

        $app_name = $this->ask(__('adminify.questions.app_name'));
        
        $keys['APP_NAME'] = $app_name;

        $user_db = $this->ask(__('adminify.questions.user_db'));
        
        $keys['DB_USERNAME'] = $user_db;

        $password_db = $this->ask(__('adminify.questions.password_db'));

        $keys['DB_PASSWORD'] = $password_db;

        $db_name = $this->ask(__('adminify.questions.db_name'));

        $keys['DB_DATABASE'] = $db_name;

        $this->setEnvironmentValue($keys);

        return 0;
    }
}
