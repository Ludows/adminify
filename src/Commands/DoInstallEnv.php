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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $app_url = $this->ask(__('adminify.questions.app_url'));
        
        $this->call('env:set', [
            'key' => 'APP_URL',
            'value' => $app_url
        ]);

        $app_name = $this->ask(__('adminify.questions.app_name'));
        
        $this->call('env:set',[
            'key' => 'APP_NAME',
            'value' => $app_name
        ]);

        $user_db = $this->ask(__('adminify.questions.user_db'));
        
        $this->call('env:set', [
            'key' => 'DB_USERNAME',
            'value' => $user_db
        ]);

        $password_db = $this->ask(__('adminify.questions.password_db'));

        $this->call('env:set', [
            'key' => 'DB_PASSWORD',
            'value' => $password_db
        ]);

        $db_name = $this->ask(__('adminify.questions.db_name'));

        $this->call('env:set', [
            'key' => 'DB_DATABASE',
            'value' => $db_name
        ]);

        return 0;
    }
}
